const { ensureSchema, getPool, isAdminRequest, json, readBody } = require('./_db');

module.exports = async function handler(req, res) {
  if (!['GET', 'POST', 'DELETE'].includes(req.method)) {
    return json(res, 405, { ok: false, message: 'Method not allowed.' });
  }

  try {
    await ensureSchema();

    if (req.method === 'GET') {
      if (!isAdminRequest(req)) {
        return json(res, 401, { ok: false, message: 'Admin code is required.' });
      }

      const result = await getPool().query(
        `select id, name, email, rating, message, created_at
         from customer_feedback
         order by created_at desc
         limit 50`
      );

      return json(res, 200, { ok: true, feedback: result.rows });
    }

    if (req.method === 'DELETE') {
      if (!isAdminRequest(req)) {
        return json(res, 401, { ok: false, message: 'Admin code is required.' });
      }

      const requestUrl = new URL(req.url || '/', 'https://praisty-resort.vercel.app');
      const id = Number(requestUrl.searchParams.get('id'));

      if (!id) {
        return json(res, 422, { ok: false, message: 'A valid feedback id is required.' });
      }

      const result = await getPool().query(
        'delete from customer_feedback where id = $1 returning id',
        [id]
      );

      if (!result.rows[0]) {
        return json(res, 404, { ok: false, message: 'Feedback was not found.' });
      }

      return json(res, 200, { ok: true, message: 'Feedback deleted successfully.' });
    }

    const body = await readBody(req);
    const guest = body.guest || {};
    const name = String(guest.name || body.name || '').trim();
    const email = String(guest.email || body.email || '').trim().toLowerCase();
    const rating = Number(body.rating || 5);
    const message = String(body.message || '').trim();

    if (!name || !email || !message) {
      return json(res, 422, { ok: false, message: 'Guest details and feedback message are required.' });
    }

    const guestResult = await getPool().query('select id from guest_accounts where email = $1 limit 1', [email]);
    const guestId = guestResult.rows[0]?.id || null;
    await getPool().query(
      'insert into customer_feedback (guest_id, name, email, rating, message) values ($1, $2, $3, $4, $5)',
      [guestId, name, email, rating, message]
    );

    return json(res, 201, { ok: true, message: 'Thank you. Your feedback was sent to the Praisty admin team.' });
  } catch (error) {
    return json(res, 500, { ok: false, message: error.message || 'Feedback failed.' });
  }
};
