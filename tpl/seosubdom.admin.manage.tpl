<!-- BEGIN: MAIN -->

<h2><!-- IF {PHP.id} > 0 -->{PHP.L.seos_edit_domain}<!-- ELSE -->{PHP.L.seos_add_domain}<!-- ENDIF --></h2>
{FILE "system/admin/tpl/warnings.tpl"}
<form method="post" name="manage_city" action="{ADMIN_SEOS_MANAGE_FORM_URL}">
<div class="block">
	<table class="cells">

		<!-- IF {PHP.id} > 0 -->
		<tr>
			<td style="width: 35%;"><strong>{PHP.L.Id}</strong></td>
			<td style="width: 65%;">{ADMIN_SEOS_MANAGE_DOMAIN_ID}</td>
		</tr>
		<!-- ENDIF -->
		<tr>
			<td style="width: 35%;"><strong>{PHP.L.seos_domain}</strong></td>
			<td style="width: 65%;">{ADMIN_SEOS_MANAGE_DOMAIN}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_address_index}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_ADDRESS_INDEX}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_address_region}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_ADDRESS_REGION}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_address_city}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_ADDRESS_CITY}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_address_street}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_ADDRESS_STREET}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_address_house}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_ADDRESS_HOUSE}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_address_office}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_ADDRESS_OFFICE}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_address_working_days}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_ADDRESS_WORKING_DAYS}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_address_working_hours}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_ADDRESS_WORKING_HOURS}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_phone}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_PHONE}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_mail}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_MAIL}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_video}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_VIDEO}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_image}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_IMAGE}</td>
		</tr>
		<tr>
			<td><strong>{PHP.L.cfg_default_map_coordinate}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_MAP_COORDINATE}</td>
		</tr>
		<tr>
			<td><strong>{ADMIN_SEOS_MANAGE_EMPLOYEE_CTA_TITLE}</strong></td>
			<td>{ADMIN_SEOS_MANAGE_EMPLOYEE_CTA}</td>
		</tr>
	</table>
</div>

<h2>{PHP.L.cfg_default_description}</h2>

<div class="block">
	<table style="width:100%;">
		<tr>
			<td style="padding-top: 25px;" colspan="2">{ADMIN_SEOS_MANAGE_DESCRIPTION}</td>
		</tr>
	</table>
</div>

<div class="block" style="text-align: center;">
	<button type="submit"><!-- IF {PHP.id} > 0 -->{PHP.L.Update}<!-- ELSE -->{PHP.L.Add}<!-- ENDIF --></button>
</div>
</form>
<!-- END: MAIN -->