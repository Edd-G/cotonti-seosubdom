<!-- BEGIN: MAIN -->

<h2>{PHP.L.seos}</h2>
{FILE "system/admin/tpl/warnings.tpl"}
<div class=" button-toolbar block">
		<a title="{PHP.L.Configuration}" href="{ADMIN_SEOS_CONFIG_URL}" class="button">{PHP.L.Configuration}</a>
		<a href="{ADMIN_SEOS_DOMAINS_ADD_URL}" class="button special">{PHP.L.seos_add_domain}</a>
</div>

<div class="block">
	<h3>{PHP.L.seos_domains}:</h3>
	<table class="cells">
		<tr>
			<td class="right" colspan="5">
				<form id="seos_filter" name="form_seos_filter" method="get" action="{ADMIN_SEOS_FORM_FILTER_URL}">
				<input name="p" type="hidden" value="seosubdom"/>
				<span style="text-align: middle;">{PHP.L.seos_sort}:</span> &nbsp; {ADMIN_SEOS_ORDER} &nbsp;  {ADMIN_SEOS_WAY} &nbsp; &nbsp;
				{ADMIN_SEOS_ONE_PAGE} &nbsp; &nbsp;
				<button type="submit">{PHP.L.Filter}</button>
				</form><br>
				{PHP.L.seos_sort_fl}:&nbsp; &nbsp;<ul style="display:inline-block; list-style: none;">{ADMIN_SEOS_FL_LINK}</ul>
			</td>
		</tr>
		<tr>
			<td class="coltop width5">{PHP.L.seos_id}</td>
			<td class="coltop width15">{PHP.L.seos_domain}</td>
			<td class="coltop width25">{PHP.L.seos_city}</td>
			<td class="coltop width25">{PHP.L.seos_phone}</td>
			<td class="coltop width20">{PHP.L.Action}</td>
		</tr>
<!-- BEGIN: ADMIN_SEOS_DOMAINS -->
		<tr>
			<td class="centerall">
				{ADMIN_SEOS_ID}
			</td>
			<td>
				{ADMIN_SEOS_DOMAIN}

			</td>
			<td>
				{ADMIN_SEOS_CITY}

			</td>
			<td>
				{ADMIN_SEOS_PHONE}

			</td>
			<td class="action" style="text-align: center;">
				<a title="{PHP.L.Edit}" href="{ADMIN_SEOS_MANAGE_URL}" class="button">{PHP.L.Edit}</a>
				<a title="{PHP.L.Delete}" href="{ADMIN_SEOS_DELETE_URL}" class="confirmLink button">{PHP.L.short_delete}</a>
			</td>
		</tr>
<!-- END: ADMIN_SEOS_DOMAINS -->
<!-- BEGIN: ADMIN_SEOS_NO_DOMAINS -->
		<tr>
			<td class="centerall" colspan="5">{PHP.L.None}</td>
		</tr>
<!-- END: ADMIN_SEOS_NO_DOMAINS -->
	</table>
	
	<!-- IF !{PHP.op} -->
		<p class="paging">
			{ADMIN_SEOS_PAGENAV_PREV}{ADMIN_SEOS_PAGENAV_MAIN}{ADMIN_SEOS_PAGENAV_NEXT}<span>{PHP.L.Total}: {ADMIN_SEOS_TOTALITEMS}, {PHP.L.Onpage}: {ADMIN_SEOS_ON_PAGE}</span>
		</p>
	<!-- ENDIF -->
	</form>
</div>

<!-- END: MAIN -->