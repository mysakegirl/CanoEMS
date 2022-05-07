$(document).ready(function() {
    $("#btnChangePassword").on("click", async function() {
        const { value: formValues } = await Swal.fire({
            title: "Change Password",
            html: `
            <div class="form-group row">
                <label for="changeOldPword" class="col-sm-4 col-form-label mt-4">Old Password:</label>
                <div class="col-sm-8">
                    <input id="changeOldPword" type="password" placeholder="Enter Old Password" class="swal2-input ml-0 mr-0">
                </div>
            </div>
            <div class="form-group row">
                <label for="changeNewPword" class="col-sm-4 col-form-label mt-4">New Password:</label>
                <div class="col-sm-8">
                    <input id="changeNewPword" type="password" placeholder="Enter New Password" class="swal2-input ml-0 mr-0">
                </div>
            </div>`,
            focusConfirm: false,
            preConfirm: () => {
                return [
                    document.getElementById("changeOldPword").value,
                    document.getElementById("changeNewPword").value,
                ];
            },
        });

        if (formValues) {
            var user_id = $("#cur_user").attr("cur-user-id");
            var oldPassword = formValues[0];
            var password = formValues[1];

            if (password == "") {
                Swal.fire({
                    icon: "error",
                    title: "Empty Field/s Detected!",
                    text: "Fillout all requried fields.",
                });
            } else {
                var data = {
                    updatecurrentuserpassword: 1,
                    user_id: user_id,
                    oldpassword: oldPassword,
                    password: password,
                };

                $.ajax({
                    url: "/ems/methods/authController.php",
                    type: "POST",
                    data: data,
                    success: function(response) {
                        console.log(response);
                        if (response.includes("success")) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Password Updated.",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        } else if (response.includes("not match")) {
                            Swal.fire({
                                icon: "error",
                                title: "Old password not match",
                                text: "Please double check the password.",
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Failed to change password",
                                text: response,
                            });
                        }
                    },
                });
            }
        }
    });
});