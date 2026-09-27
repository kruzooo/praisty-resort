const { json, readBody } = require('../_db');

module.exports = async function handler(req, res) {
  if (req.method !== 'POST') {
    return json(res, 405, { ok: false, message: 'Method not allowed.' });
  }

  try {
    const body = await readBody(req);
    const identifier = String(body.staff_identifier || body.email || '').trim().toLowerCase();
    const password = String(body.password || '');
    const code = String(body.two_factor_code || body.code || '').trim();

    const adminEmail = String(process.env.PRAISTY_ADMIN_EMAIL || 'pryvstfpedrera@gmail.com').toLowerCase();
    const adminPassword = process.env.PRAISTY_ADMIN_PASSWORD || 'Kruzo0530';
    const adminCode = process.env.PRAISTY_ADMIN_CODE || '053008';

    if (identifier !== adminEmail || password !== adminPassword || code !== adminCode) {
      return json(res, 401, { ok: false, message: 'Invalid admin credentials or 2FA code.' });
    }

    return json(res, 200, {
      ok: true,
      admin: {
        name: 'Praisty Administrator',
        email: adminEmail,
      },
    });
  } catch (error) {
    return json(res, 500, { ok: false, message: error.message || 'Admin login failed.' });
  }
};
