require('typeahead.js');
let Bloodhound = require('bloodhound-js');

$(document).ready(function () {
    const searchUrl = Routing.generate('api_employee_handle_search');
    console.log(searchUrl);
    // Bilaketa
    const engines = new Bloodhound(
        {
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,

            remote: {
                url: searchUrl + '/%q%',
                wildcard: '%q%'
            },
            filter: function (engine) {
                console.log(engine);
                return $.map(engine, function(e){
                    return {
                        izena: e.name,
                        abizena1: e.abizena1,
                        abizena2: e.abizena2
                    }
                });
            }
        }
    );
    engines.initialize();
    $('#inputMainSearchForm').typeahead({
        highlight: true,
        minLength: 3
    },
    {
        name: 'engines',
        source: engines.ttAdapter(),
        display: 'izena' + 'abizena1' + 'abizena2',
        limit: 10,
        templates: {
            empty: '<div class="suggestion"><span class="suggestion_text no-underline">   Ez dago daturik   </span></div>',
            suggestion: function (el) {
                const searchUrl = Routing.generate('employee_show', {'id':el.id});
                return `<a href="` + searchUrl + `"><div class="ProfileCard-details">
                            <div class="ProfileCard-realName">` + el.name + ` ` + el.abizena1 + ` `+ el.abizena2 + `</div>
                            <div class="ProfileCard-screenName">(NAN.: ` + el.nan + `)</div>
                            <div class="ProfileCard-description">Telf: `+ el.telefono +` - Email: ` + el.email + `</div>
                        </div>
                        </a>
                `
            }
        }
    });
});
