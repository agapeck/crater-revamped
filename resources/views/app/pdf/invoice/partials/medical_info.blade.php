<div class="medical-info-container">
    <table width="100%">
        <tr>
            <td colspan="2" class="medical-info-heading">
                <b>Medical Information</b>
            </td>
        </tr>
        <tr>
            <td class="attribute-label">Age</td>
            <td class="attribute-value">&nbsp;{{ $invoice->customer->age ?? '-' }}</td>
        </tr>
        <tr>
            <td class="attribute-label">Next of Kin</td>
            <td class="attribute-value">&nbsp;{{ $invoice->customer->next_of_kin ?? '-' }}</td>
        </tr>
        <tr>
            <td class="attribute-label">Next of Kin Phone</td>
            <td class="attribute-value">&nbsp;{{ $invoice->customer->next_of_kin_phone ?? '-' }}</td>
        </tr>
        <tr>
            <td class="attribute-label">Diagnosis</td>
            <td class="attribute-value">&nbsp;{{ $invoice->customer->diagnosis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="attribute-label">Treatment</td>
            <td class="attribute-value">&nbsp;{{ $invoice->customer->treatment ?? '-' }}</td>
        </tr>
        <tr>
            <td class="attribute-label">Attended to by</td>
            <td class="attribute-value">&nbsp;{{ $invoice->customer->attended_by ?? '-' }}</td>
        </tr>
        <tr>
            <td class="attribute-label">Review Date</td>
            <td class="attribute-value">&nbsp;{{ $invoice->customer->review_date ? $invoice->customer->review_date->format(\Crater\Models\CompanySetting::getSetting('carbon_date_format', $invoice->customer->company_id)) : '-' }}</td>
        </tr>
    </table>
</div> 