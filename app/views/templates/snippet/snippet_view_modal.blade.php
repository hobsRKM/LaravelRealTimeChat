	
<script src="fusionmate/public/plugins/src-min-noconflict/ace.js"></script>
<!-- load ace language tools -->
<script src="fusionmate/public/plugins/src-min-noconflict/ext-language_tools.js"></script>


<script src="fusionmate/public/plugins/src-min-noconflict/show_own_source.js"></script>
<style>
    .snippetContent{
        overflow-y: auto !important;
    }
</style>
<!-- Modal -->
<div id="viewSnippet" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Snippet</h4>
            </div>
            <div class="modal-body">

                <blockquote  class="m-b-5 snippetHeader" id='inner'>

                </blockquote>
                <br/> 
                <pre id="editor1" class="snippetContent">
                </pre>

            </div>
            <div class="modal-footer">
                    <!--<button id="codeSnippet" class="btn btn-success waves-effect">Upload&nbsp;<i class="zmdi zmdi-mail-send"></i></button>-->

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script>
    /**
     * 
     * Intitalize ace here as ace doesnt work in externally included js file
     */
    var snippetData;
    function viewSnippet(snipetId) {
        $('#viewSnippet').find('.snippetHeader').html('');

        $.ajax({
            url: "/get_snippet_code",
            type: "POST",
            dataType: "text",
            data: {snipetId: snipetId}
        }).done(function (data) {

            var pattern = /html|json|perl|css|java|sql|php|javascript|cs|python|ruby|cpp/i;

            data.replace(pattern, function replacer(match) {
                uploadedSnippetLang = match;
            });
            snippetData = data.replace("snippet$#fmslipt$" + uploadedSnippetLang + "$#fmslipt$", "");
            $("#viewSnippet").modal("show");
            $('#viewSnippet').find('.snippetHeader').append('<p>' + uploadedSnippetLang.toUpperCase() + ' snippet</p>');
            viewEditor("sql");
        });
    }

    function viewEditor() {

        ace.require("ace/ext/language_tools");
        var editor = ace.edit("editor1");
        editor.setOption("wrap", 80);
        editor.getSession().setMode("ace/mode/" + uploadedSnippetLang);
        editor.setTheme("ace/theme/tomorrow");
        //Set the content obtained from backend to setValue funtion
        editor.session.setValue(snippetData);

        // enable autocompletion and snippets
        editor.setOptions({
            enableBasicAutocompletion: true,
            enableSnippets: true,
            enableLiveAutocompletion: false,
            maxLines: 100
        });
    }
</script>