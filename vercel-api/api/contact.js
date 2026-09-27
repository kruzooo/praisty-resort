const { ensureSchema, getPool, isAdminRequest, json, readBody } = require('./_db');

module.exports = async function handler(req, res) {
  if (req.method !== 'GET' && req.method !== 'POST') {
    return json(res, 405, { ok: false, message: 'Method not allowed.' });
  }

  try {
    await ensureSchema();

    if (req.method === 'GET') {
      if (!isAdminRequest(req)) {
        return json(res, 401, { ok: false, message: 'Admin code is required.' });
      }

      const result = await getPool().query(
        `select id, name, email, subject, message, created_at
         from contact_messages
         order by created_at desc
         limit 50`
      );

      return json(res, 200, { ok: true, messages: result.rows });
    }

    const body = await readBody(req);
    const name = String(body.name || '').trim();
    const email = String(body.email || '').trim();
    const subject = String(body.subject || 'general').trim();
    const message = String(body.message || '').trim();

    if (!name || !email || !message) {
      return json(res, 422, { ok: false, message: 'Name, email, and message are required.' });
    }

    await getPool().query(
      'insert into contact_messages (name, email, subject, message) values ($1, $2, $3, $4)',
      [name, email, subject, message]
    );

    return json(res, 201, { ok: true, message: 'Thank you. Your inquiry was sent to the Praisty team.' });
  } catch (error) {
    return json(res, 500, { ok: false, message: error.message || 'Message failed.' });
  }
};
