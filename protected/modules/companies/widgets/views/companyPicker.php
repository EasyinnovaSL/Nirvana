<?php

use yii\widgets\ActiveForm;
use \yii\helpers\Html;
?>


<?php echo $form->field($model, 'company_name')->textInput(); ?>


<script>
    $(document).ready(function() {

        var companies = new Bloodhound({
            datumTokenizer: function (datum) {
                return Bloodhound.tokenizers.whitespace(datum.value);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '<?php echo $companySearchUrl; ?>',
                replace: function (url, query) {
                    return '<?php echo $companySearchUrl; ?>' + query.toUpperCase()
                },
                wildcard: '%QUERY',
                filter: function (companies) {
                    return $.map(companies, function (company) {
                        return {
                            id: company.id,
                            company_name: company.company_name,
                            company_linkedin: company.company_linkedin,
                            website: company.website,
                            contact_name: company.contact_name,
                            contact_email: company.contact_email,
                            contact_linkedin: company.contact_linkedin
                        };
                    });
                }
            }
        });

        // Initialize the Bloodhound suggestion engine
        companies.initialize();

        // Instantiate the Typeahead UI
        $('#company-company_name').typeahead({
            hint: true,
            highlight: true,
            minLength: 2,
            updater: function (item) {
                console.log(item);
            }
        }, {
            limit: 20,
            displayKey: 'company_name',
            templates: {
                empty: [
                    '<div class="noitems">',
                    'No Items Found',
                    '</div>'
                ].join('\n')
            },
            source: companies.ttAdapter(),
        }).on('typeahead:selected', function(event, selection) {

            $('#company-company_linkedin').val(selection.company_linkedin);
            $('#company-website').val(selection.website);
            $('#company-contact_name').val(selection.contact_name);
            $('#company-contact_email').val(selection.contact_email);
            $('#company-contact_linkedin').val(selection.contact_linkedin);

        });

    });
</script>