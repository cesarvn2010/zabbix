<?php
/*
** Zabbix
** Copyright (C) 2001-2017 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
**/


$widget_div = (new CDiv())
	->addClass(ZBX_STYLE_SYSMAP)
	->setId(uniqid());

if ($data['error'] === null) {
	$table = (new CTableInfo())->setHeader([_('Timestamp'), _('Value')]);

	foreach ($data['table_rows'] as $table_row) {
		$table->addRow($table_row);
	}

	$widget_div->addItem($table);
}
else {
	$table = (new CTableInfo())->setNoDataMessage($data['error']);
}

$output = [
	'header' => $data['name'],
	'body' => $table->toString(),
	'footer' => (new CList())
		->addItem(_s('Updated: %s', zbx_date2str(TIME_FORMAT_SECONDS)))
		->addClass(ZBX_STYLE_DASHBRD_WIDGET_FOOT)
		->toString()
];

if ($data['user']['debug_mode'] == GROUP_DEBUG_MODE_ENABLED) {
	CProfiler::getInstance()->stop();
	$output['debug'] = CProfiler::getInstance()->make()->toString();
}

echo (new CJson())->encode($output);