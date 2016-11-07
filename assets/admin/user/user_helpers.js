/**
 * Created by carlosrenato on 05-12-16.
 */
$(function() {
    $('#add_username').focus();
    $("#tabtitle").html("Users");
    watchingInputs();

    // Watch any change on user inputs
    function watchingInputs() {
        $('.addUserField').on('keypress paste change', function (e) {
            $('.submitUserBtn#submitAddUserForm').prop('disabled', false);

        });

        $('.addUserField').on('keyup', function (e) {
            if (e.keyCode == 8 || e.keyCode == 46) {
                $('.submitUserBtn#submitAddUserForm').prop('disabled', false);
            } else {
                e.preventDefault();
            }
        });

        $('#emailEnabledField .eecx').on('change', function (e) {
            $('.submitUserBtn#submitAddUserForm').prop('disabled', false);
        });
    }
});

/**
 * HELPERS from customer...
 */
function check_email(val) {
    if(!val.match(/\S+@\S+\.\S+/)){
        return false;
    }
    if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
        return false;
    }
    return true;
}

function countChar() {
    var len = $("#phone1").val().length;
    if (len >= 6) {
        //do nothing
    } else {
        $('#phone1').val("");
    }
}
