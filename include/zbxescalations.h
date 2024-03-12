/*
** Zabbix
** Copyright (C) 2001-2024 Zabbix SIA
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
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/

#ifndef ZABBIX_ESCALATIONS_H
#define ZABBIX_ESCALATIONS_H

#include "zbxalgo.h"
#include "zbxdbhigh.h"
#include "zbxipcservice.h"

typedef int (*zbx_rtc_notify_generic_cb_t)(zbx_ipc_async_socket_t *rtc, unsigned char process_type, int process_num,
		zbx_uint32_t code, const char *data, zbx_uint32_t size);

void	zbx_init_escalations(int escalators_num, zbx_rtc_notify_generic_cb_t rtc_notify_cb);
void	zbx_start_escalations(zbx_ipc_async_socket_t *rtc, zbx_vector_escalation_new_ptr_t *escalations);

#endif
