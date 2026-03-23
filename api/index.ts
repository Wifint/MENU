import type { VercelRequest, VercelResponse } from '@vercel/node';
import Database from 'better-sqlite3';

const db = new Database('./database/tecnet.sqlite');

type TableName = 'funciones' | 'protocolos' | 'circulares';

function getDataFromTable(table: TableName, page: number, limit: number) {
  const offset = (page - 1) * limit;

  try {
    const countStmt = db.prepare(`SELECT COUNT(*) as total FROM ${table}`);
    const totalRecords = (countStmt.get() as { total: number }).total;
    const totalPages = Math.ceil(totalRecords / limit);

    if (page > totalPages && totalPages > 0) {
      return { success: false, error: 'Página fuera de rango', status: 400 };
    }

    const stmt = db.prepare(`
      SELECT id, titulo, descripcion, url, fecha_creacion
      FROM ${table}
      ORDER BY fecha_creacion DESC
      LIMIT ? OFFSET ?
    `);

    const data = stmt.all(limit, offset);
    const from = totalRecords > 0 ? offset + 1 : 0;
    const to = Math.min(offset + limit, totalRecords);

    return {
      success: true,
      data,
      pagination: {
        current_page: page,
        per_page: limit,
        total_records: totalRecords,
        total_pages: totalPages,
        from,
        to
      }
    };

  } catch (error) {
    return { success: false, error: 'Error al obtener los datos', status: 500 };
  }
}

export default function handler(req: VercelRequest, res: VercelResponse) {
  const { url } = req;
  const params = new URL(url || '', `https://${req.headers.host}`);
  
  const pathParts = params.pathname.split('/').filter(Boolean);
  const table = pathParts[pathParts.length - 1] as TableName;

  if (!['funciones', 'protocolos', 'circulares'].includes(table)) {
    return res.status(404).json({ success: false, error: 'Endpoint no encontrado' });
  }

  const page = parseInt(params.searchParams.get('page') || '1');
  const limit = Math.min(parseInt(params.searchParams.get('limit') || '10'), 100);

  const result = getDataFromTable(table, page, limit);

  return res.status(result.status || 200).json(result);
}
