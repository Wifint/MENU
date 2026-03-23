import type { VercelRequest, VercelResponse } from '@vercel/node';
import { readFileSync } from 'fs';
import { join } from 'path';

type TableName = 'funciones' | 'protocolos' | 'circulares';

function getData(table: TableName) {
  try {
    const dataPath = join(process.cwd(), 'data', `${table}.json`);
    const data = JSON.parse(readFileSync(dataPath, 'utf-8'));
    return data;
  } catch (error) {
    console.error('Error reading data:', error);
    return [];
  }
}

export default function handler(req: VercelRequest, res: VercelResponse) {
  try {
    const urlParts = req.url?.split('?') || ['', ''];
    const pathname = urlParts[0];
    const pathParts = pathname.split('/').filter(Boolean);
    const table = pathParts[pathParts.length - 1] as TableName;

    if (!['funciones', 'protocolos', 'circulares'].includes(table)) {
      res.status(404).json({ success: false, error: 'Endpoint no encontrado' });
      return;
    }

    const searchParams = new URL(req.url || '/', 'http://localhost').searchParams;
    const page = parseInt(searchParams.get('page') || '1');
    const limit = Math.min(parseInt(searchParams.get('limit') || '10'), 100);
    const offset = (page - 1) * limit;

    const allData = getData(table);
    const totalRecords = allData.length;
    const totalPages = Math.ceil(totalRecords / limit);

    if (page > totalPages && totalPages > 0) {
      res.status(400).json({ success: false, error: 'Página fuera de rango' });
      return;
    }

    const paginatedData = allData.slice(offset, offset + limit);
    const from = totalRecords > 0 ? offset + 1 : 0;
    const to = Math.min(offset + limit, totalRecords);

    res.status(200).json({
      success: true,
      data: paginatedData,
      pagination: {
        current_page: page,
        per_page: limit,
        total_records: totalRecords,
        total_pages: totalPages,
        from,
        to
      }
    });

  } catch (error: any) {
    console.error('Error:', error);
    res.status(500).json({ success: false, error: error.message || 'Error al obtener los datos' });
  }
}
