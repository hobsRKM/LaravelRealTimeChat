<script src="fusionmate/public/plugins/src-min-noconflict/ace.js"></script>
<!-- load ace language tools -->
<script src="fusionmate/public/plugins/src-min-noconflict/ext-language_tools.js"></script>


<script src="fusionmate/public/plugins/src-min-noconflict/show_own_source.js"></script>
<script src="fusionmate/public/plugins/js/fileupload.js"></script>
<script>


</script>
<!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">

                <blockquote  class="m-b-5" id='inner'>
                    <p>Select Programming Language of Code to Upload</p>
                </blockquote>
                <div class="col-sm-12">

                    <select class="chosen chzn-select"  data-placeholder="Choose a Country...">
                        <option value="html">HTML, XML</option>
                        <option value="sql">SQL</option>
                        <option value="php">PHP</option>
                        <option value="java">Java</option>
                        <option value="javascript">JavaScript</option>
                        <option value="css">CSS</option>
                        <option value="cs">C#</option>
                        <option value="json">JSON</option>
                        <option value="perl">Perl</option>
                        <option value="python">Python</option>
                        <option value="ruby">Ruby</option>
                        <option value="cpp">C++</option>


                    </select>
                </div>
                <br/> <br/> 
                <blockquote  class="m-b-5 selectSnippetBox" id='inner'>
                    <p>Paste Or Type your code</p>
                </blockquote>
                <pre id="create_editor" class="textareaCustom" contenteditable></pre>
            </div>
            <div class="modal-footer">
                <button id="codeSnippet" class="btn btn-success waves-effect">Upload&nbsp;<i class="zmdi zmdi-mail-send"></i></button>

                <button type="button" class="btn btn-default" onclick="closeSnipetModal()">Close</button>
            </div>
        </div>

    </div>
</div>


<script>
    $(document).ready(function () {
        $(".chzn-select").chosen().change(function () {
            var languageSelected = $(this).val();
            aceEditor(languageSelected, true);

        });
        $("#codeSnippet").click(function () {
            aceEditor(programmingLanguage, true);
            sendMessage(activeChannelId, personalOrGeneral);
            closeSnipetModal();
        });
    });
    /**
     * 
     * Intitalize ace here as ace doesnt work in externally included js file
     */
    function initializeAce() {
        aceEditor("html", true);
    }
    function closeSnipetModal() {
        $('#myModal1').modal('hide');

        aceEditor(programmingLanguage, false);
    }
    function aceEditor(languageSelected, uploadBegin) {
        ace.require("ace/ext/language_tools");
        var editor = ace.edit("create_editor");
        editor.getSession().setMode("ace/mode/" + languageSelected);
        editor.setTheme("ace/theme/tomorrow");
        if (uploadBegin) {
            snippetBody = editor.getValue(); // or session.getValue
            programmingLanguage = languageSelected;
            /*
             * While displaying snippet code explode the data using '$#fmslipt$'
             */
            snippetCode = "snippet" + "$#fmslipt$" + programmingLanguage + "$#fmslipt$" + snippetBody;
        } else {
            editor.setValue();
        }
        // enable autocompletion and snippets
        editor.setOptions({
            enableBasicAutocompletion: true,
            enableSnippets: true,
            enableLiveAutocompletion: false
        });
    }



</script>
