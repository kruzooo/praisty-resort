const { ensureSchema, getPool, hashPassword, json, publicGuest, readBody } = require('../_db');

module.exports = async function handler(req, res) {
  if (req.method !== 'POST') {
    return json(res, 405, { ok: false, message: 'Method not allowed.' });
  }

  try {
    await ensureSchema();
    const body = await readBody(req);
    const name = String(body.name || '').trim();
    const email = String(body.email || '').trim().toLowerCase();
    const password = String(body.password || '');
    const birthday = body.date_of_birth || null;

    if (!name || !email || !password) {
      return json(res, 422, { ok: false, message: 'Name, email, and password are required.' });
    }

    if (password.length < 8) {
      return json(res, 422, { ok: false, message: 'Password must be at least 8 characters.' });
    }

    if (birthday) {
      const cutoff = new Date();
      cutoff.setFullYear(cutoff.getFullYear() - 18);
      if (new Date(birthday) > cutoff) {
        return json(res, 422, { ok: false, message: 'You must be at least 18 years old to create an account.' });
      }
    }

    const result = await getPool().query(
      `insert into guest_accounts (name, email, date_of_birth, password_hash)
       values ($1, $2, $3, $4)
       returning id, name, email`,
      [name, email, birthday, hashPassword(password)]
    );

    return json(res, 201, { ok: true, guest: publicGuest(result.rows[0]) });
  } catch (error) {
    if (error.code === '23505') {
      return json(res, 409, { ok: false, message: 'That email already has an account. Please sign in.' });
    }

    return json(res, 500, { ok: false, message: error.message || 'Registration failed.' });
  }
};
