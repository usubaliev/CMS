    $(document).ready(function() {

        // CKEditor
        ClassicEditor
            .create(document.querySelector('#body'))
            .catch(error => {
                console.error(error);
            });

        //Check / Uncheck all checkboxes in 'Admin Posts' list for bulk options
        $('#selectAllBoxes').click(function(event) {
            if (this.checked) {
                $('.checkBoxes').each(function() {
                    this.checked = true;
                });
            } else {
                $('.checkBoxes').each(function() {
                    this.checked = false;
                });
            }
        });

        // preloader
        /* var div_box = "<div id='load-screen'><div id='loading'></div></div>";
        $("body").prepend(div_box);
        $('#load-screen').delay(500).fadeOut(400, function() {
            $(this).remove();
        }); */

        // Users Online (instantly)
        function loadUsersOnline() {
            $.get("functions.php?onlineusers=result", function(data) {
                $(".usersonline").text(data);
            });
        }
        setInterval(function() {
            loadUsersOnline();
        }, 500);
        loadUsersOnline();
    });