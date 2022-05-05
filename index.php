<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <style>
        .required,
        .error {
            color: red;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .radio-container {
            margin-top: 20px;
        }

        #file_size_error{
            color: red;
        }
      
    </style>
                                                <!-- Start of PHP -->
     <?php

    //defining variables
    $name = '';
    $email = '';
    $website = '';
    $phone = '';
    $countries = '';
    $message = '';
    $gender = '';
  


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Store post data and trim
        $name = trim(htmlspecialchars($_POST["fname"]));
        $email = trim(htmlspecialchars($_POST["email"]));
        $website = trim(htmlspecialchars($_POST["website"]));
        $phone = trim(htmlspecialchars($_POST["phone"]));
        $countries = trim(htmlspecialchars($_POST["countries"]));
        $message = trim(htmlspecialchars($_POST["message"]));
        
        if(isset($_FILES['profile']['tmp_name'])){
            echo $_FILES['profile']['tmp_name'];
        }else{
            echo "Nooooo";
        }

        //file upload validation ------------------------------------------------------------------------

        if (!is_uploaded_file($_FILES['profile']['tmp_name'])) {
            $imageErr = "Please select a profile imageeee";
        } else {
            // File Upload start if user uploads a file
            $target_dir = "/uploads";
            $target_file = $target_dir . basename($_FILES["profile"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["profile"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $imageErr = "File is not an image.";
                $uploadOk = 0;
            }
            
            if (file_exists($target_file)) {
                $imageErr = "This image is already exists";
                $uploadOk = 0;
            } elseif ($_FILES["profile"]["size"] > 10000000) {
                $imageErr = "Maximim size should be 10MB";
                $uploadOk = 0;
            } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $imageErr = "Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            } elseif ($uploadOk == 0) {
                $imageErr = "Sorry, your file was not uploaded.";
            } elseif (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
                $imageUploaded = "Profile photo uploaded sucessfully.";
            } else {
                $imageErr = "Sorry, there was an error uploading your file.";
            }
        }
        //File upload End----------------------------------------------------------------------------------

      
        //store gender in $gender
        if (isset($_POST["gender"])) {
            $gender = $_POST["gender"];
        }

        //validate name field
        if (empty($name)) {
            $nameErr = "Please type in your name";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $nameErr = "Only letters are accepted";
        }

        //validate email address
        if (empty($email)) {
            $emailErr = "Please enter an email address";
        } elseif (!preg_match("/^[a-zA-Z0-9\._]+@[a-zA-Z]+[\.][a-zA-Z]+$/", $email)) {
            $emailErr = "Please enter a valid email address";
        }

        //validate URL
        if (empty($website)) {
            $urlErr = "Please enter a website URL";
        } elseif (!preg_match("%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu", $website)) {
            $urlErr = "Please enter valid website URL";
        }

        //validate phone number
        if (empty($phone)) {
            $numberErr = "Please enter a phone number";
        } elseif (!preg_match("/^[0-9\+]{10,11}+$/", $phone)) {
            $numberErr = "Please enter a valid phone number";
        }

        //validate gender input
        if (empty($gender)) {
            $genderErr = "Please select a gender";
        }

        //validate country input
        if ($countries == 'select') {
            $countryErr = "Please select a country";
        }

       
    }
    ?>

                                            <!-- Start of HTML -->
    <div class="container mt-5">

        <form id="commentForm" action="" method="post">



            <!-- Name Input -->
            <div class="form-outline mb-4">
                <label for="fname">Name (required, at least 2 characters)</label>
                <input id="fname" class="form-control" value="<?php echo $name ?>" name="fname" type="text" placeholder="Name" >
                <?php
                if (isset($nameErr)) {
                    echo "<p class='error'>$nameErr</p>";
                } ?>
                   
                </span>
            </div>

            <!-- Email Input -->
            <div class="form-outline mb-4">
                <label for="email">E-Mail <span class="required">*</span></label>
                <input id="email" class="form-control" value="<?php echo $email ?>" type="text" name="email" placeholder="Email Address" >
                </span>
                <?php if (isset($emailErr)) {
                    echo "<p class='error'>$emailErr</p>";
                } ?>
                
            </div>


            <!-- URL Input -->
            <div class="form-outline mb-4">
                <label for="website">URL <span class="required">*</span></label>
                <input id="website" class="form-control" value="<?php echo $website ?>" type="text" name="website" placeholder="Website URL" >
                <?php if (isset($urlErr)) {
                    echo "<p class='error'>$urlErr</p>";
                }

                ?>
            </div>


            <!-- Phone Input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="phone">Phone <span class="required">*</span></label>
                
                <input  type="tel" id="phone" name="phone" value="<?php echo $phone ?>" class="form-control" placeholder="Phone Number" />
                <?php
                if (isset($numberErr)) {
                    echo "<p class='error'>$numberErr</p>";
                }
                ?>
            </div>

            <!-- Gender -->
            <div class="form-outline mb-4">
                <label for='gender'>Select Gender: <span class="required">*</span></label>
                <br>
                <input <?php if (isset($_POST['gender']) && $_POST['gender'] == 'male') {
                            echo "checked";
                        }
                        ?> class="form-check-input" type="radio" name="gender" id="male" value="male" />
                <label for="male">Male</label>

                <input <?php if (isset($_POST['gender']) && $_POST['gender'] == 'female') {
                            echo "checked";
                        }
                        ?> class="form-check-input" type="radio" name="gender" id="female" value="female" />
                <label for="female">Female</label>

                <?php
                if (isset($genderErr)) {
                    echo "<p class='error'>$genderErr</p>";
                }
                ?>
            </div>

            <!-- Country -->
            <div class="form-outline mb-4">
                <label class="form-label" for="country" placeholder="Select a country">Country <span class="required">*</span></label>
                <select id="countrylist" class="form-select" name="countries" >
                    <option value="0" >- Select -</option>
                    <option value="AF">Afghanistan</option>
                    <option value="AX">Åland Islands</option>
                    <option value="AL">Albania</option>
                    <option value="DZ">Algeria</option>
                    <option value="AS">American Samoa</option>
                    <option value="AD">Andorra</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguilla</option>
                    <option value="AQ">Antarctica</option>
                    <option value="AG">Antigua and Barbuda</option>
                    <option value="AR">Argentina</option>
                    <option value="AM">Armenia</option>
                    <option value="AW">Aruba</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="AZ">Azerbaijan</option>
                    <option value="BS">Bahamas (the)</option>
                    <option value="BH">Bahrain</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbados</option>
                    <option value="BY">Belarus</option>
                    <option value="BE">Belgium</option>
                    <option value="BZ">Belize</option>
                    <option value="BJ">Benin</option>
                    <option value="BM">Bermuda</option>
                    <option value="BT">Bhutan</option>
                    <option value="BO">Bolivia (Plurinational State of)</option>
                    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                    <option value="BA">Bosnia and Herzegovina</option>
                    <option value="BW">Botswana</option>
                    <option value="BV">Bouvet Island</option>
                    <option value="BR">Brazil</option>
                    <option value="IO">British Indian Ocean Territory (the)</option>
                    <option value="BN">Brunei Darussalam</option>
                    <option value="BG">Bulgaria</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="CV">Cabo Verde</option>
                    <option value="KH">Cambodia</option>
                    <option value="CM">Cameroon</option>
                    <option value="CA">Canada</option>
                    <option value="KY">Cayman Islands (the)</option>
                    <option value="CF">Central African Republic (the)</option>
                    <option value="TD">Chad</option>
                    <option value="CL">Chile</option>
                    <option value="CN">China</option>
                    <option value="CX">Christmas Island</option>
                    <option value="CC">Cocos (Keeling) Islands (the)</option>
                    <option value="CO">Colombia</option>
                    <option value="KM">Comoros (the)</option>
                    <option value="CD">Congo (the Democratic Republic of the)</option>
                    <option value="CG">Congo (the)</option>
                    <option value="CK">Cook Islands (the)</option>
                    <option value="CR">Costa Rica</option>
                    <option value="HR">Croatia</option>
                    <option value="CU">Cuba</option>
                    <option value="CW">Curaçao</option>
                    <option value="CY">Cyprus</option>
                    <option value="CZ">Czechia</option>
                    <option value="CI">Côte d'Ivoire</option>
                    <option value="DK">Denmark</option>
                    <option value="DJ">Djibouti</option>
                    <option value="DM">Dominica</option>
                    <option value="DO">Dominican Republic (the)</option>
                    <option value="EC">Ecuador</option>
                    <option value="EG">Egypt</option>
                    <option value="SV">El Salvador</option>
                    <option value="GQ">Equatorial Guinea</option>
                    <option value="ER">Eritrea</option>
                    <option value="EE">Estonia</option>
                    <option value="SZ">Eswatini</option>
                    <option value="ET">Ethiopia</option>
                    <option value="FK">Falkland Islands (the) [Malvinas]</option>
                    <option value="FO">Faroe Islands (the)</option>
                    <option value="FJ">Fiji</option>
                    <option value="FI">Finland</option>
                    <option value="FR">France</option>
                    <option value="GF">French Guiana</option>
                    <option value="PF">French Polynesia</option>
                    <option value="TF">French Southern Territories (the)</option>
                    <option value="GA">Gabon</option>
                    <option value="GM">Gambia (the)</option>
                    <option value="GE">Georgia</option>
                    <option value="DE">Germany</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GR">Greece</option>
                    <option value="GL">Greenland</option>
                    <option value="GD">Grenada</option>
                    <option value="GP">Guadeloupe</option>
                    <option value="GU">Guam</option>
                    <option value="GT">Guatemala</option>
                    <option value="GG">Guernsey</option>
                    <option value="GN">Guinea</option>
                    <option value="GW">Guinea-Bissau</option>
                    <option value="GY">Guyana</option>
                    <option value="HT">Haiti</option>
                    <option value="HM">Heard Island and McDonald Islands</option>
                    <option value="VA">Holy See (the)</option>
                    <option value="HN">Honduras</option>
                    <option value="HK">Hong Kong</option>
                    <option value="HU">Hungary</option>
                    <option value="IS">Iceland</option>
                    <option value="IN">India</option>
                    <option value="ID">Indonesia</option>
                    <option value="IR">Iran (Islamic Republic of)</option>
                    <option value="IQ">Iraq</option>
                    <option value="IE">Ireland</option>
                    <option value="IM">Isle of Man</option>
                    <option value="IL">Israel</option>
                    <option value="IT">Italy</option>
                    <option value="JM">Jamaica</option>
                    <option value="JP">Japan</option>
                    <option value="JE">Jersey</option>
                    <option value="JO">Jordan</option>
                    <option value="KZ">Kazakhstan</option>
                    <option value="KE">Kenya</option>
                    <option value="KI">Kiribati</option>
                    <option value="KP">Korea (the Democratic People's Republic of)</option>
                    <option value="KR">Korea (the Republic of)</option>
                    <option value="KW">Kuwait</option>
                    <option value="KG">Kyrgyzstan</option>
                    <option value="LA">Lao People's Democratic Republic (the)</option>
                    <option value="LV">Latvia</option>
                    <option value="LB">Lebanon</option>
                    <option value="LS">Lesotho</option>
                    <option value="LR">Liberia</option>
                    <option value="LY">Libya</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lithuania</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MO">Macao</option>
                    <option value="MG">Madagascar</option>
                    <option value="MW">Malawi</option>
                    <option value="MY">Malaysia</option>
                    <option value="MV">Maldives</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malta</option>
                    <option value="MH">Marshall Islands (the)</option>
                    <option value="MQ">Martinique</option>
                    <option value="MR">Mauritania</option>
                    <option value="MU">Mauritius</option>
                    <option value="YT">Mayotte</option>
                    <option value="MX">Mexico</option>
                    <option value="FM">Micronesia (Federated States of)</option>
                    <option value="MD">Moldova (the Republic of)</option>
                    <option value="MC">Monaco</option>
                    <option value="MN">Mongolia</option>
                    <option value="ME">Montenegro</option>
                    <option value="MS">Montserrat</option>
                    <option value="MA">Morocco</option>
                    <option value="MZ">Mozambique</option>
                    <option value="MM">Myanmar</option>
                    <option value="NA">Namibia</option>
                    <option value="NR">Nauru</option>
                    <option value="NP">Nepal</option>
                    <option value="NL">Netherlands (the)</option>
                    <option value="NC">New Caledonia</option>
                    <option value="NZ">New Zealand</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NE">Niger (the)</option>
                    <option value="NG">Nigeria</option>
                    <option value="NU">Niue</option>
                    <option value="NF">Norfolk Island</option>
                    <option value="MP">Northern Mariana Islands (the)</option>
                    <option value="NO">Norway</option>
                    <option value="OM">Oman</option>
                    <option value="PK">Pakistan</option>
                    <option value="PW">Palau</option>
                    <option value="PS">Palestine, State of</option>
                    <option value="PA">Panama</option>
                    <option value="PG">Papua New Guinea</option>
                    <option value="PY">Paraguay</option>
                    <option value="PE">Peru</option>
                    <option value="PH">Philippines (the)</option>
                    <option value="PN">Pitcairn</option>
                    <option value="PL">Poland</option>
                    <option value="PT">Portugal</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="MK">Republic of North Macedonia</option>
                    <option value="RO">Romania</option>
                    <option value="RU">Russian Federation (the)</option>
                    <option value="RW">Rwanda</option>
                    <option value="RE">Réunion</option>
                    <option value="BL">Saint Barthélemy</option>
                    <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                    <option value="KN">Saint Kitts and Nevis</option>
                    <option value="LC">Saint Lucia</option>
                    <option value="MF">Saint Martin (French part)</option>
                    <option value="PM">Saint Pierre and Miquelon</option>
                    <option value="VC">Saint Vincent and the Grenadines</option>
                    <option value="WS">Samoa</option>
                    <option value="SM">San Marino</option>
                    <option value="ST">Sao Tome and Principe</option>
                    <option value="SA">Saudi Arabia</option>
                    <option value="SN">Senegal</option>
                    <option value="RS">Serbia</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leone</option>
                    <option value="SG">Singapore</option>
                    <option value="SX">Sint Maarten (Dutch part)</option>
                    <option value="SK">Slovakia</option>
                    <option value="SI">Slovenia</option>
                    <option value="SB">Solomon Islands</option>
                    <option value="SO">Somalia</option>
                    <option value="ZA">South Africa</option>
                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                    <option value="SS">South Sudan</option>
                    <option value="ES">Spain</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="SD">Sudan (the)</option>
                    <option value="SR">Suriname</option>
                    <option value="SJ">Svalbard and Jan Mayen</option>
                    <option value="SE">Sweden</option>
                    <option value="CH">Switzerland</option>
                    <option value="SY">Syrian Arab Republic</option>
                    <option value="TW">Taiwan (Province of China)</option>
                    <option value="TJ">Tajikistan</option>
                    <option value="TZ">Tanzania, United Republic of</option>
                    <option value="TH">Thailand</option>
                    <option value="TL">Timor-Leste</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinidad and Tobago</option>
                    <option value="TN">Tunisia</option>
                    <option value="TR">Turkey</option>
                    <option value="TM">Turkmenistan</option>
                    <option value="TC">Turks and Caicos Islands (the)</option>
                    <option value="TV">Tuvalu</option>
                    <option value="UG">Uganda</option>
                    <option value="UA">Ukraine</option>
                    <option value="AE">United Arab Emirates (the)</option>
                    <option value="GB">United Kingdom of Great Britain and Northern Ireland (the)</option>
                    <option value="UM">United States Minor Outlying Islands (the)</option>
                    <option value="US">United States of America (the)</option>
                    <option value="UY">Uruguay</option>
                    <option value="UZ">Uzbekistan</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VE">Venezuela (Bolivarian Republic of)</option>
                    <option value="VN">Viet Nam</option>
                    <option value="VG">Virgin Islands (British)</option>
                    <option value="VI">Virgin Islands (U.S.)</option>
                    <option value="WF">Wallis and Futuna</option>
                    <option value="EH">Western Sahara</option>
                    <option value="YE">Yemen</option>
                    <option value="ZM">Zambia</option>
                    <option value="ZW">Zimbabwe</option>
                </select>
                <div style="color:red;" id="countryErr"></div>
                
            </div>

            
            <!-- Message Input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="message">Message (Optional)</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Type your message here"></textarea>

            </div>

            <!-- Profile Photo -->
            <div class="form-outline mb-4">
                <label class="form-label" for="message">Profile Image <span class="required">*</span></label> <br />
                <i class="d-block mb-2">jpg/jpeg/png, max 10mb</i>
                <input type="file" name="profile" class="demoInputBox" id="profilepic" />
                <div style="color:red;" id="fileErr"></div>
                <span id="file_size_error"></span>
                <?php
                if (isset($imageErr)) {
                    echo "<p class='error'>$imageErr</p>";
                }
                ?>
               
            </div>


            <!-- Checkbox -->
            <div class="form-check d-flex mb-4">
                <input class="form-check-input me-2" type="checkbox" value="1" id="copyMessage" name="copyMessage" > 
                <label class="form-check-label" for="copyMessage">
                    Send me a copy of this message
                </label>
            </div>


            <!-- Submit Button -->
            <button type="submit" id="btnSubmit" class="btn btn-primary btn-block mb-4" name="submit">Send</button>

        </form>

        <div class="results">

            <?php
            if (isset($nameErr) || isset($emailErr) || isset($websiteErr) || isset($numberErr) || isset($genderErr) || isset($countryErr)) {
                echo "<p class='error'>Please fill all required fields</p>";
            } else {
                if (!empty($name) && !empty($email) && !empty($website) && !empty($phone) && !empty($gender)) {
                    echo "
                    <h3>Your details submited sucessfully</h3>
                    <ul>
                        <li>$name</li>
                        <li>$email</li>
                        <li>$website</li>
                        <li>$phone</li>
                        <li>$gender</li>
                        <li>$countries</li>
                        <li>$message</li>
                       
                    </ul>
                    
                    ";
                }
            }
            ?>

            </ul>
        </div>


                                    <!-- Start of jQuery -->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- jQuery Validation plugin -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
            integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

        <script>
        $(document).ready(() => {

            //country select validate
            $.validator.addMethod("checkCountry", function(value, element, arg) {
                return arg != value;
            }, "Please select a country");

            //File size 10mb validate
            $.validator.addMethod('uploadFile', function(val, element) {
                var size = element.files[0].size;

                if (size > 10485760) {
                    return false;
                } else {
                    return true;
                }

            }, "Max file size is 10mb");

            $.validator.addMethod("isText", function(val, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/.test(val);
            }, "Please enter only letters");

            //initiate validator rules and error messages
            $("#commentForm").validate({
                rules: {
                    fname: {
                        required: true,
                        isText: true
                    },
                    gender: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    website: {
                        required: true,
                        url: true
                    },
                    phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 11
                    },
                    profile: {
                        required: true,
                        extension: "png|jpe?g",
                        uploadFile: true
                    },
                    countryy: {
                        checkCountry: "select"
                    }
                },
                messages: {
                    fname: {
                        required: "Please enter your name",
                        isText: "Only letters are accepted"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    gender: {
                        required: "Please select a gender"
                    },
                    website: {
                        required: "Please enter a website URL",
                        url: "Given URL is not valid"
                    },
                    phone: {
                        required: "Please enter a phone number",
                        minlength: "Enter a valid number",
                        maxlength: "phone number is too long"
                    },
                    countryy: {
                        required: "Please select a country",
                    },
                    profile: {
                        required: "Please upload a profile photo",
                        extension: "Image should be JPG, JPEG or PNG"
                    }

                },

                // html error placement for gender radio buttons error messa
                errorPlacement: function(error, element) {
                    if (element.is(":radio")) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        })
    </script>

  

    </div>

</body>

</html>