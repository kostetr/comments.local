<div class="card text-center">
    <?php include_once 'cp_menu_view.php'; ?>
    <div class="card-body">
        <div class="list-group"> 
            <div class="d-flex justify-content-center">
                <form method="POST" action="/CP/savenotes">					
                    <p><b>Заметки:</b></p>                    
                    <p><textarea rows="25" cols="130"  name="notes" id="notes" oninput="FunctionNotesChange()"><?= $this->notes[0]['notes'] ?></textarea></p>
                    <p>Дата последнего сохранения: <?= $this->notes[0]['date'] ?></p>
                    <p><input type="submit" id="submitnotes" class="btn btn-lg btn-primary btn-block" value="Сохранить" disabled></p>
                </form>
            </div>

        </div>
        <div id="work-counteiner">
            <table id="work-table">
                <tr>
                    <td>1. - </td>
                    <td><input type="text" id="copyTarget" value=""> <button id="copyButton">Copy</button></td>
                </tr>
                <tr>
                    <td>2. - </td>
                    <td><input type="text" id="copyTarget1" value=""> <button id="copyButton1">Copy</button></td>
                </tr>
                <tr>
                    <td>3. - </td>
                    <td><input type="text" id="copyTarget2" value=""> <button id="copyButton2">Copy</button></td>
                </tr>
                <tr>
                    <td>4. - </td>
                    <td><input type="text" id="copyTarget3" value=""> <button id="copyButton3">Copy</button></td>
                </tr>
                <tr>
                    <td>5. - </td>
                    <td><input type="text" id="copyTarget4" value=""> <button id="copyButton4">Copy</button></td>
                </tr>
                <tr>
                    <td>6. - </td>
                    <td><input type="text" id="copyTarget5" value=""> <button id="copyButton5">Copy</button></td>
                </tr>
            </table>
        </div>
    </div>

</div>
<script>
    function FunctionNotesChange() {
        $('#submitnotes').removeAttr('disabled');
        $("#submitnotes").removeClass("btn-primary");
        $("#submitnotes").addClass("btn-warning");
    }
    ;
    document.getElementById("copyButton").addEventListener("click", function () {
        copyToClipboard(document.getElementById("copyTarget"));
    });
    document.getElementById("copyButton1").addEventListener("click", function () {
        copyToClipboard(document.getElementById("copyTarget1"));
    });
    document.getElementById("copyButton2").addEventListener("click", function () {
        copyToClipboard(document.getElementById("copyTarget2"));
    });
    document.getElementById("copyButton3").addEventListener("click", function () {
        copyToClipboard(document.getElementById("copyTarget3"));
    });
    document.getElementById("copyButton4").addEventListener("click", function () {
        copyToClipboard(document.getElementById("copyTarget4"));
    });
    document.getElementById("copyButton5").addEventListener("click", function () {
        copyToClipboard(document.getElementById("copyTarget5"));
    });

    function copyToClipboard(elem) {
        // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        if (isInput) {
            // can just use the original source element for the selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);

        // copy the selection
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch (e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }

        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        return succeed;
    }
</script>