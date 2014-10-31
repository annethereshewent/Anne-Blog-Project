<?php
require "common.php";

if (!isset($_SESSION["login"]))
    Common::redirect("/login.php");

$profile_pic = isset($_SESSION["userpic"]) ? $_SESSION["userpic"] : "images/user_icon.png";


    
?>

<html>
<head>
<link href="/css/default.css" rel="stylesheet" type="text/css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link href="/css/froala_editor.min.css" rel="stylesheet" type="text/css">
<style>
.profile {
    width:600px;
    margin-left:325px;
}
.form-heading {
    color:#6200A3;
}
.profile-pic {
    max-width:80px;
    max-height:80px;
    -webkit-border-radius: 80px;
    -moz-border-radius: 80px;
    border-radius: 80px;
}
.profilepic-container {
    text-align:center;
    margin-bottom:20px;
}
.sub-heading {
    color:#6200A3;
    font-style:italic;
    font-size:12px;
    margin-top:-20px;
}
#security-row {
    opacity:0;
}
#profile-pic:hover {
    background:#000;
    opacity: 0.2;
    -webkit-transition-duration: 0.5s;
    -moz-transition-duration: 0.5s;
}
#profilePicModal {
    height:350px;
    width:350px;
}
#simplemodal-overlay {
    background: #000;
}

.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
    text-align:center;
    box-shadow: 3px 3px 1px #888888;

}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
.modal-upload {
    margin-left:75px;
    width:20%;
    margin-bottom:20px
}
#fileupload-btn {
    width:70px;
    height:20px;
}
#description {
    outline:none;
    resize:none;
    -webkit-border-radius:5px;
    -moz-border-radius:5px;
    border-radius:5px;
    witdh:120px;
    height:80px;
}
</style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-main">
        <div class="title">
            <?= $_SESSION["title"] ?>.
        </div>
        <?php if (isset($_SESSION["userpic"]) && $_SESSION["userpic"] != "") { ?>
            <div class="img-container">
                <img class="sidebar-image" src="<?= $_SESSION["userpic"] ?>">
            </div>
        <?php } ?>

            <div class="description">
               <?= $_SESSION["description"] ?>
            </div>

        <nav class="links">
            <ul>
                <li><a href="/blog/<?= $_SESSION["displayname"] ?>">home</a></li>
                
                <?php if (isset($_SESSION["login"])) {  ?> 
                    <li><a href="#" onClick="openNewModal();return false;">new</a></li>
                <?php } ?>            
                
                <li><a href="/login.php">control panel</a></li>
                <li><a href="/contact.php">contact</a></li>
                
                <?php if (isset($_SESSION["login"])) { ?>
                    <li><a href="/logout.php">logout</a></li>
                <?php } ?> 
            </ul>
        </nav>
    </div>
</aside>
	
    <div class="profile content">
        <h2 class="form-heading">General</h2>
        <p class ="sub-heading">Display settings for the general look and feel of your blog.</p>
        <form name="profile" id="profile" method="post" action="update_general.php">
            <div class="profilepic-container">
                <a href="#" onClick="openEditProfPicModal(); return false;" ><img class="profile-pic" title="Change Profile Picture" src="<?= $profile_pic ?>" alt="images/user_icon.png"></img></a>
                <label class="control-label">Profile Picture</label>
            </div>
            <div class="inputs row">
                <div class="col">
                    <label class="control-label">Blog Title:</label>
                    <input type="text" class="control-text xlg" value="<?= $_SESSION["title"] ?>" id="blog_title" name="blog_title">
                </div>
                <div class="col">
                    <label class="control-label">Username:</label>
                    <input type="text" class="control-text xlg" value="<?= $_SESSION["displayname"] ?>" id="username" name="username">
                </div>
             </div>
             <div style="margin-bottom:10px"></div>
             <div style="margin-left:200px;margin-bottom:20px">    
                 <div class="inputs row">
                    <label class="control-label">Short Description of your Blog:</label>
                    <textarea class="control-text" name="description" id="description"><?= isset($_SESSION["description"]) ? $_SESSION["description"] : "" ?></textarea>
                </div>
            </div>
             <div class="inputs" style="text-align:center">
                <button type="submit" class="btn confirm btn-lg">Save Changes</button>
            </div>
        </form>
         <hr>
         <h2 class="form-heading">Security</h2>
         <p class ="sub-heading">Password and E-mail Changes</p>
         <div id="secpass-section">
             <div class="inputs" id="secpass-section">
                <label class="control-label"><i>Please enter current password to continue:</i></label>
                <input type="password" class="control-text lg" name="sec-pass" id="sec-pass" placeholder="Password"> 
            </div>
            <div class="inputs">
                <button type="button" class="btn warn" onClick="checkPassword()">Verify</button>
            </div>
            <img src="images/loading.gif" style="display:none" id="loading-gif"></img>
        </div>
        <div style="margin-bottom:20px"></div>
        <form name="security-form" id="security-form" method="post" action="process_security.php"> 
            <div id="security-row">
                <div class="inputs row">
                    <label class="control-label">Change E-mail:</label>
                    <input type="text" name="email" id="email" class="control-text lg" placeholder="New E-mail Address">
                </div>
                <div style="margin-bottom:20px"></div>
                <label class="control-label">Change Password:</label>
            
                <div class="inputs row">
                    <input type="password" placeholder="Enter New Password" class="control-text lg" name="pass1" id="pass1" class="control-text lg">
                </div>
                <div class="inputs row">
                    <input type="password" placeholder="Re-enter Password" class="control-text lg" name="pass2" id="pass2" class="control-text lg">
                    <p class="error"></p>
                </div>
                <div class="inputs" style="text-align:center">
                    <button type="button" onClick="validate()" class="btn confirm btn-lg">Save Changes</button>
                </div>
            </div>
        </form>
    </div>


    <!-- jQuery, misc js -->
    <script src="/js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="/js/jquery.simplemodal-1.4.4.js" type="text/javascript"></script>
    <script src="/js/froala_editor.min.js"></script>
    <script src="/js/main.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            initEditor();
            $("#upload-pic").change(function() {
                var temp = ($(this).val()).split("\\");
                var filename = temp[temp.length-1];
                temp = null;
                $("#uploadTxt").val(filename);
            });
        });
        function checkPassword() {
            $("#loading-gif").show();
            $.ajax({
                url: "acct-check_pass.php",
                type: "GET",
                data: {password: $("#sec-pass").val()},
                success: function(result) {
                    $("#sec-pass").val("");
                    $("#loading-gif").hide();
                    if (result) {
                        $("#secpass-section").fadeOut(500).hide();
                        $("#security-row").fadeIn(500).css("opacity", "1");
                    }
                }
            });
        }

        function openEditProfPicModal() {
            $("#profilePicModal").fadeIn(500).modal({
                opacity:50, 
                overlayClose:true,
                position: ["200px", "200px"]
            });
        }
        function validate() {
            var errorMsg = $("#pass2").next();
            $(errorMsg).hide();
            if ($("#pass1").val() == "" && $("#email").val() == "" && $("#pass2").val() == "") {
                $(errorMsg).html("<i>An error has occurred.</i>");
                $(errorMsg).show();
            }
            else if ($("#pass1").val().length > 0 && $("#pass1").val().length < 8) {
                $(errorMsg).html("<i>Password must be at least 8 characters.</i>");
                $(errorMsg).show();
            }
            else if ($("#pass1").val() != $("#pass2").val()) {
                $(errorMsg).html("<i>Passwords must match.</i>");
                $(errorMsg).show();
            }
            else
                $("#security-form").submit();

        }
    </script>
</body>
<div class="content" id="profilePicModal" style="display:none">
    <h2 class="form-heading">Update Avatar</h2>
    <p class="sub-heading">Avatar will be resized to 125x125 pixels.</p>
    <form enctype="multipart/form-data" name="upd_profpic" id="upd_profpic" method="post" action="update_avatar.php">
        <div class="modal-upload">
            <img style="margin-left:20px" class="profile-pic" src="<?= $profile_pic ?>">
            <input type="text" id="uploadTxt" disabled="true" placeholder="Choose File.." style="border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px">            
            <div class="fileUpload btn warn" id="fileupload-btn" style="margin-left:20px">
                <span>Select</span>
                <input type="file" class="upload" name="upload-pic" id="upload-pic">
            </div> 
        </div>
         <div class="inputs">
            <button style="margin-right:40px" type="submit" class="btn confirm">Save</button>
            <button type="button" class="btn cancel simplemodal-close">Cancel</button>
        </div>
        <div class="inputs">
            <img src="images/loading.gif" style="display:none" id="modal-loading">
        </div>
    </form>
</div>

<div class="content" id="postModal" style="display:none">
    <p style="color:#7A7ACC;margin-left:10px">Create a New Post</p>
    <form name="newPost" id="newPost" method="post" action="newpost.php">
            <div name="blogpost" id="editContents"></div>
            <div  style="margin-left:15px;"class="buttonarea">
               <button type="button" onClick="submitContents()" id="blogSubmit" class="btn confirm sm" style="margin-right:20px">Post</button><button type="button" class="simplemodal-close btn cancel sm">Cancel</button>
            </div>
            <input type="hidden" name="htmlContent" id="htmlContent">
    </form>
</div>

</html>