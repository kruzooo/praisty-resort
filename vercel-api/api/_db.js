const crypto = require('crypto');
const { Pool } = require('pg');

let pool;
let schemaReady;

function getConnectionString() {
  const connectionString = process.env.POSTGRES_URL_NON_POOLING || process.env.POSTGRES_URL || process.env.POSTGRES_PRISMA_URL;

  if (!connectionString) {
    return null;
  }

  try {
    const url = new URL(connectionString);
    url.searchParams.delete('sslmode');
    url.searchParams.set('sslmode', 'no-verify');
    return url.toString();
  } catch {
    return connectionString;
  }
}

function getPool() {
  if (!pool) {
    const connectionString = getConnectionString();

    if (!connectionString) {
      throw new Error('Supabase Postgres environment variables are not configured.');
    }

    process.env.NODE_TLS_REJECT_UNAUTHORIZED = '0';
    pool = new Pool({
      connectionString,
      ssl: { rejectUnauthorized: false },
    });
  }

  return pool;
}

function json(res, status, payload) {
  res.statusCode = status;
  res.setHeader('Content-Type', 'application/json');
  res.setHeader('Cache-Control', 'no-store');
  res.end(JSON.stringify(payload));
}

function handleOptions(req, res) {
  if (req.method !== 'OPTIONS') {
    return false;
  }

  res.statusCode = 204;
  res.setHeader('Access-Control-Allow-Origin', req.headers.origin || '*');
  res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
  res.end();
  return true;
}

function isAdminRequest(req) {
  const configuredCode = process.env.PRAISTY_ADMIN_CODE || '053008';
  const requestUrl = new URL(req.url || '/', 'https://praisty-resort.vercel.app');
  const submittedCode = req.headers['x-admin-code'] || requestUrl.searchParams.get('code');

  return String(submittedCode || '') === configuredCode;
}

function readBody(req) {
  return new Promise((resolve, reject) => {
    let body = '';
    req.on('data', (chunk) => {
      body += chunk;
      if (body.length > 1_000_000) {
        reject(new Error('Request body is too large.'));
        req.destroy();
      }
    });
    req.on('end', () => {
      const contentType = req.headers['content-type'] || '';

      if (contentType.includes('application/json')) {
        resolve(body ? JSON.parse(body) : {});
        return;
      }

      const params = new URLSearchParams(body);
      resolve(Object.fromEntries(params.entries()));
    });
    req.on('error', reject);
  });
}

function hashPassword(password, salt = crypto.randomBytes(16).toString('hex')) {
  const hash = crypto.scryptSync(String(password), salt, 64).toString('hex');
  return `${salt}:${hash}`;
}

function verifyPassword(password, storedHash) {
  if (!storedHash || !storedHash.includes(':')) {
    return false;
  }

  const [salt, hash] = storedHash.split(':');
  const candidate = hashPassword(password, salt).split(':')[1];
  return crypto.timingSafeEqual(Buffer.from(hash, 'hex'), Buffer.from(candidate, 'hex'));
}

function publicGuest(row) {
  return {
    id: row.id,
    name: row.name,
    email: row.email,
  };
}

async function ensureSchema() {
  if (!schemaReady) {
    schemaReady = (async () => {
      const client = await getPool().connect();
      try {
        await client.query('select pg_advisory_lock(27183019)');
        await client.query(`
          create table if not exists guest_accounts (
            id bigserial primary key,
            name text not null,
            email text not null unique,
            date_of_birth date,
            password_hash text not null,
            created_at timestamptz not null default now(),
            updated_at timestamptz not null default now()
          );

          create table if not exists contact_messages (
            id bigserial primary key,
            name text not null,
            email text not null,
            subject text,
            message text not null,
            created_at timestamptz not null default now()
          );

          create table if not exists reservations (
            id bigserial primary key,
            guest_id bigint references guest_accounts(id) on delete set null,
            guest_name text not null,
            guest_email text not null,
            room_slug text not null,
            check_in date,
            check_out date,
            guests integer not null default 1,
            status text not null default 'processing',
            created_at timestamptz not null default now()
          );

          create table if not exists customer_feedback (
            id bigserial primary key,
            guest_id bigint references guest_accounts(id) on delete set null,
            name text not null,
            email text not null,
            rating integer not null default 5,
            message text not null,
            created_at timestamptz not null default now()
          );
        `);
      } finally {
        await client.query('select pg_advisory_unlock(27183019)').catch(() => {});
        client.release();
      }
    })();
  }

  await schemaReady;
}

module.exports = {
  ensureSchema,
  getPool,
  handleOptions,
  hashPassword,
  isAdminRequest,
  json,
  publicGuest,
  readBody,
  verifyPassword,
};
