const { ensureSchema, getPool, isAdminRequest, json, readBody } = require('./_db');

module.exports = async function handler(req, res) {
  if (!['GET', 'PATCH', 'POST'].includes(req.method)) {
    return json(res, 405, { ok: false, message: 'Method not allowed.' });
  }

  try {
    await ensureSchema();

    if (req.method === 'GET') {
      if (!isAdminRequest(req)) {
        return json(res, 401, { ok: false, message: 'Admin code is required.' });
      }

      const result = await getPool().query(
        `select id, guest_name, guest_email, room_slug, check_in, check_out, guests, status, created_at
         from reservations
         order by created_at desc
         limit 50`
      );

      return json(res, 200, { ok: true, reservations: result.rows });
    }

    if (req.method === 'PATCH') {
      if (!isAdminRequest(req)) {
        return json(res, 401, { ok: false, message: 'Admin code is required.' });
      }

      const body = await readBody(req);
      const id = Number(body.id);
      const status = String(body.status || '').trim();

      if (!id || !['processing', 'booked', 'cancelled'].includes(status)) {
        return json(res, 422, { ok: false, message: 'Valid reservation id and status are required.' });
      }

      const result = await getPool().query(
        `update reservations
         set status = $1
         where id = $2
         returning id, status`,
        [status, id]
      );

      if (!result.rows[0]) {
        return json(res, 404, { ok: false, message: 'Reservation was not found.' });
      }

      return json(res, 200, { ok: true, reservation: result.rows[0] });
    }

    const body = await readBody(req);
    const guest = body.guest || {};
    const name = String(guest.name || body.name || '').trim();
    const email = String(guest.email || body.email || '').trim().toLowerCase();
    const roomSlug = String(body.room_slug || body.room || '').trim();
    const guests = Number(body.guests || 1);

    if (!name || !email || !roomSlug) {
      return json(res, 422, { ok: false, message: 'Guest and room details are required.' });
    }

    const guestResult = await getPool().query('select id from guest_accounts where email = $1 limit 1', [email]);
    const guestId = guestResult.rows[0]?.id || null;
    const result = await getPool().query(
      `insert into reservations (guest_id, guest_name, guest_email, room_slug, check_in, check_out, guests)
       values ($1, $2, $3, $4, $5, $6, $7)
       returning id, status`,
      [guestId, name, email, roomSlug, body.check_in || null, body.check_out || null, guests]
    );

    return json(res, 201, {
      ok: true,
      reservation: {
        id: result.rows[0].id,
        status: result.rows[0].status,
      },
    });
  } catch (error) {
    return json(res, 500, { ok: false, message: error.message || 'Reservation failed.' });
  }
};
