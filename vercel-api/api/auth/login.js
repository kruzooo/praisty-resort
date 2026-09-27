const { ensureSchema, getPool, json, publicGuest, readBody, verifyPassword } = require('../_db');

module.exports = async function handler(req, res) {
  if (req.method !== 'POST') {
    return json(res, 405, { ok: false, message: 'Method not allowed.' });
  }

  try {
    await ensureSchema();
    const body = await readBody(req);
    const email = String(body.email || '').trim().toLowerCase();
    const password = String(body.password || '');

    const result = await getPool().query(
      'select id, name, email, password_hash from guest_accounts where email = $1 limit 1',
      [email]
    );

    const guest = result.rows[0];
    if (!guest || !verifyPassword(password, guest.password_hash)) {
      return json(res, 401, { ok: false, message: 'Invalid email or password.' });
    }

    return json(res, 200, { ok: true, guest: publicGuest(guest) });
  } catch (error) {
    return json(res, 500, { ok: false, message: error.message || 'Login failed.' });
  }
};
