<?php

    function wplink_global()
    {
        ?>
         <div class="wrap">
                <div id="icon-edit" class="icon32"><br /></div>
                <h2>Documentation</h2>
                <form action="#" name="form">
                <script type="text/javascript">
                    function newuarule(first, full, not,dest) {
                    var field_area = document.getElementById("uatargeting");

                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count != count)
                            {
                                count = Number(last.split(" ")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');

                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "...like <input type='text' style='background-image:url(<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/accept.png);background-repeat:repeat-x;background-position:14px;width:120px;' name='full_"+count+"' id='full_"+count+"' value='"+full+"' />, but not like <input type='text'  style='background-image:url(<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/cancel.png);background-repeat:repeat-x;background-position:14px;width:120px;' name='not_"+count+"' id='not_"+count+"' value='"+not+"' />";

                    newspan.innerHTML += "<img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_ua_"+count+"' id='dest_ua_"+count+"' style='width:40%;' />";

                    field_area.appendChild(newspan);
                    fixtextfields();
                }
                function newiprule(first, ip, dest) {
                    var field_area = document.getElementById("ipotargetting");

                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);

                     if(count != count)
                            {
                                count = Number(last.split("_")[2]);

                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');

                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "<input type='text' name='ip_"+count+"' id='ip_"+count+"' value='"+ip+"' /> <img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_ip_"+count+"' id='dest_ip_"+count+"' style='width:60%;'/>";


                    field_area.appendChild(newspan);
                    fixtextfields();
                }


                function newhostrule(first, host, dest) {
                    var field_area = document.getElementById("resolveotargetting");

                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');

                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "<input type='text' name='host_"+count+"' id='host_"+count+"' value='"+host+"' /> <img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_host_"+count+"' id='dest_host_"+count+"' style='width:60%;'/>";

                    field_area.appendChild(newspan);
                    fixtextfields();
                }


                function newrefrule(first, ref, dest) {
                    var field_area = document.getElementById("refotargetting");

                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');

                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "<input type='text' name='ref_"+count+"' id='ref_"+count+"' value='"+ref+"' /> <img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_ref_"+count+"' id='dest_ref_"+count+"' style='width:60%;'/>";


                    field_area.appendChild(newspan);
                    fixtextfields();
                }
                function newarinrule(first, arin, dest) {
                    var field_area = document.getElementById("arintargeting");

                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');

                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "<input type='text' name='arin_"+count+"' id='arin_"+count+"' value='"+arin+"' /> <img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_arin_"+count+"' id='dest_arin_"+count+"' style='width:60%;'/>";


                    field_area.appendChild(newspan);
                    fixtextfields();
                }

                function newccoderule(first, country, value) {
                    var field_area = document.getElementById("geotargetting");


                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("select");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);

                        if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    }

                    if(first) count = 1;

                    var newspan = document.createElement('span');

                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += createCCode(count);
                    newspan.innerHTML += createTo(count, value);

                    field_area.appendChild(newspan);

                    document.getElementById('ccode_' + count).selectedIndex = getOptionIndex(document.getElementById('ccode_' + count), country);

                    fixtextfields();
                }
                function newdestrule(first, dontadjust, string, weight) {
                    var field_area = document.getElementById("destination_block");
                    var all_inputs = field_area.getElementsByTagName("input");

                    if(!first) {
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count == "NaN")
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }

                    var newspan = document.createElement('span');
                    if(!first) newspan.innerHTML += "<br />";

                    newspan.innerHTML += createDestTo(count, string, weight);
                    field_area.appendChild(newspan);

                    if(!dontadjust) {
                        for(var i=0; i<all_inputs.length+1;i++) {
                            var working = all_inputs[i].id
                            if(working.split("_")[0] == "weight") {
                                if(all_inputs[i].value == (100/(count-1))) {
                                    all_inputs[i].value = ""+(100/count);
                                }
                            }
                        }
                    }
                    fixtextfields();
                }

                function createDestTo(count, value, weight) {
                    if(weight == "" || typeof(weight) == "undefined") {
                        weight = 100/count;
                    }
                    return "<input name='dest_to_" + count+"' id='dest_to_" + count+"' type='text' value='" + value + "' style='width:80%'  /><input type='text' name='weight_"+count+"' id='weight_"+count+"' value='"+weight+"' size='2' style='width:3em;'/>%";

                }

                function createTo(count, value) {
                    return "<input type='text' name='to_" + count + "' id='to_" + count + "' style='width:440px;' value='"+value+"' />";
                }

                function createCCode(count) {
                    return '<select style="width:200px;" name="ccode_' + count + '" id="ccode_' + count + '">\
                                <option value="AF">Afghanistan</option>\
                                <option value="AL">Albania</option>\
                                <option value="DZ">Algeria</option>\
                                <option value="AS">American Samoa</option>\
                                <option value="AD">Andorra</option>\
                                <option value="AO">Angola</option>\
                                <option value="AI">Anguilla</option>\
                                <option value="AQ">Antarctica</option>\
                                <option value="AG">Antigua and Barbuda</option>\
                                <option value="AR">Argentina</option>\
                                <option value="AM">Armenia</option>\
                                <option value="AW">Aruba</option>\
                                <option value="AU">Australia</option>\
                                <option value="AT">Austria</option>\
                                <option value="AZ">Azerbaijan</option>\
                                <option value="BS">Bahamas</option>\
                                <option value="BH">Bahrain</option>\
                                <option value="BD">Bangladesh</option>\
                                <option value="BB">Barbados</option>\
                                <option value="BY">Belarus</option>\
                                <option value="BE">Belgium</option>\
                                <option value="BZ">Belize</option>\
                                <option value="BJ">Benin</option>\
                                <option value="BM">Bermuda</option>\
                                <option value="BT">Bhutan</option>\
                                <option value="BO">Bolivia</option>\
                                <option value="BA">Bosnia and Herzegovina</option>\
                                <option value="BW">Botswana</option>\
                                <option value="BV">Bouvet Island</option>\
                                <option value="BR">Brazil</option>\
                                <option value="IO">British Indian Ocean Territory</option>\
                                <option value="BN">Brunei Darussalam</option>\
                                <option value="BG">Bulgaria</option>\
                                <option value="BF">Burkina Faso</option>\
                                <option value="BI">Burundi</option>\
                                <option value="KH">Cambodia</option>\
                                <option value="CM">Cameroon</option>\
                                <option value="CA">Canada</option>\
                                <option value="CV">Cape Verde</option>\
                                <option value="KY">Cayman Islands</option>\
                                <option value="CF">Central African Republic</option>\
                                <option value="TD">Chad</option>\
                                <option value="CL">Chile</option>\
                                <option value="CN">China</option>\
                                <option value="CX">Christmas Island</option>\
                                <option value="CC">Cocos (Keeling) Islands</option>\
                                <option value="CO">Colombia</option>\
                                <option value="KM">Comoros</option>\
                                <option value="CG">Congo</option>\
                                <option value="CD">Congo, the Democratic Republic of the</option>\
                                <option value="CK">Cook Islands</option>\
                                <option value="CR">Costa Rica</option>\
                                <option value="CI">Cote D\'Ivoire</option>\
                                <option value="HR">Croatia</option>\
                                <option value="CU">Cuba</option>\
                                <option value="CY">Cyprus</option>\
                                <option value="CZ">Czech Republic</option>\
                                <option value="DK">Denmark</option>\
                                <option value="DJ">Djibouti</option>\
                                <option value="DM">Dominica</option>\
                                <option value="DO">Dominican Republic</option>\
                                <option value="EC">Ecuador</option>\
                                <option value="EG">Egypt</option>\
                                <option value="SV">El Salvador</option>\
                                <option value="GQ">Equatorial Guinea</option>\
                                <option value="ER">Eritrea</option>\
                                <option value="EE">Estonia</option>\
                                <option value="ET">Ethiopia</option>\
                                <option value="FK">Falkland Islands (Malvinas)</option>\
                                <option value="FO">Faroe Islands</option>\
                                <option value="FJ">Fiji</option>\
                                <option value="FI">Finland</option>\
                                <option value="FR">France</option>\
                                <option value="GF">French Guiana</option>\
                                <option value="PF">French Polynesia</option>\
                                <option value="TF">French Southern Territories</option>\
                                <option value="GA">Gabon</option>\
                                <option value="GM">Gambia</option>\
                                <option value="GE">Georgia</option>\
                                <option value="DE">Germany</option>\
                                <option value="GH">Ghana</option>\
                                <option value="GI">Gibraltar</option>\
                                <option value="GR">Greece</option>\
                                <option value="GL">Greenland</option>\
                                <option value="GD">Grenada</option>\
                                <option value="GP">Guadeloupe</option>\
                                <option value="GU">Guam</option>\
                                <option value="GT">Guatemala</option>\
                                <option value="GN">Guinea</option>\
                                <option value="GW">Guinea-Bissau</option>\
                                <option value="GY">Guyana</option>\
                                <option value="HT">Haiti</option>\
                                <option value="HM">Heard Island and Mcdonald Islands</option>\
                                <option value="VA">Holy See (Vatican City State)</option>\
                                <option value="HN">Honduras</option>\
                                <option value="HK">Hong Kong</option>\
                                <option value="HU">Hungary</option>\
                                <option value="IS">Iceland</option>\
                                <option value="IN">India</option>\
                                <option value="ID">Indonesia</option>\
                                <option value="IR">Iran, Islamic Republic of</option>\
                                <option value="IQ">Iraq</option>\
                                <option value="IE">Ireland</option>\
                                <option value="IL">Israel</option>\
                                <option value="IT">Italy</option>\
                                <option value="JM">Jamaica</option>\
                                <option value="JP">Japan</option>\
                                <option value="JO">Jordan</option>\
                                <option value="KZ">Kazakhstan</option>\
                                <option value="KE">Kenya</option>\
                                <option value="KI">Kiribati</option>\
                                <option value="KP">Korea, Democratic People\'s Republic of</option>\
                                <option value="KR">Korea, Republic of</option>\
                                <option value="KW">Kuwait</option>\
                                <option value="KG">Kyrgyzstan</option>\
                                <option value="LA">Lao People\'s Democratic Republic</option>\
                                <option value="LV">Latvia</option>\
                                <option value="LB">Lebanon</option>\
                                <option value="LS">Lesotho</option>\
                                <option value="LR">Liberia</option>\
                                <option value="LY">Libyan Arab Jamahiriya</option>\
                                <option value="LI">Liechtenstein</option>\
                                <option value="LT">Lithuania</option>\
                                <option value="LU">Luxembourg</option>\
                                <option value="MO">Macao</option>\
                                <option value="MK">Macedonia, the Former Yugoslav Republic of</option>\
                                <option value="MG">Madagascar</option>\
                                <option value="MW">Malawi</option>\
                                <option value="MY">Malaysia</option>\
                                <option value="MV">Maldives</option>\
                                <option value="ML">Mali</option>\
                                <option value="MT">Malta</option>\
                                <option value="MH">Marshall Islands</option>\
                                <option value="MQ">Martinique</option>\
                                <option value="MR">Mauritania</option>\
                                <option value="MU">Mauritius</option>\
                                <option value="YT">Mayotte</option>\
                                <option value="MX">Mexico</option>\
                                <option value="FM">Micronesia, Federated States of</option>\
                                <option value="MD">Moldova, Republic of</option>\
                                <option value="MC">Monaco</option>\
                                <option value="MN">Mongolia</option>\
                                <option value="MS">Montserrat</option>\
                                <option value="MA">Morocco</option>\
                                <option value="MZ">Mozambique</option>\
                                <option value="MM">Myanmar</option>\
                                <option value="NA">Namibia</option>\
                                <option value="NR">Nauru</option>\
                                <option value="NP">Nepal</option>\
                                <option value="NL">Netherlands</option>\
                                <option value="AN">Netherlands Antilles</option>\
                                <option value="NC">New Caledonia</option>\
                                <option value="NZ">New Zealand</option>\
                                <option value="NI">Nicaragua</option>\
                                <option value="NE">Niger</option>\
                                <option value="NG">Nigeria</option>\
                                <option value="NU">Niue</option>\
                                <option value="NF">Norfolk Island</option>\
                                <option value="MP">Northern Mariana Islands</option>\
                                <option value="NO">Norway</option>\
                                <option value="OM">Oman</option>\
                                <option value="PK">Pakistan</option>\
                                <option value="PW">Palau</option>\
                                <option value="PS">Palestinian Territory, Occupied</option>\
                                <option value="PA">Panama</option>\
                                <option value="PG">Papua New Guinea</option>\
                                <option value="PY">Paraguay</option>\
                                <option value="PE">Peru</option>\
                                <option value="PH">Philippines</option>\
                                <option value="PN">Pitcairn</option>\
                                <option value="PL">Poland</option>\
                                <option value="PT">Portugal</option>\
                                <option value="PR">Puerto Rico</option>\
                                <option value="QA">Qatar</option>\
                                <option value="RE">Reunion</option>\
                                <option value="RO">Romania</option>\
                                <option value="RU">Russian Federation</option>\
                                <option value="RW">Rwanda</option>\
                                <option value="SH">Saint Helena</option>\
                                <option value="KN">Saint Kitts and Nevis</option>\
                                <option value="LC">Saint Lucia</option>\
                                <option value="PM">Saint Pierre and Miquelon</option>\
                                <option value="VC">Saint Vincent and the Grenadines</option>\
                                <option value="WS">Samoa</option>\
                                <option value="SM">San Marino</option>\
                                <option value="ST">Sao Tome and Principe</option>\
                                <option value="SA">Saudi Arabia</option>\
                                <option value="SN">Senegal</option>\
                                <option value="CS">Serbia and Montenegro</option>\
                                <option value="SC">Seychelles</option>\
                                <option value="SL">Sierra Leone</option>\
                                <option value="SG">Singapore</option>\
                                <option value="SK">Slovakia</option>\
                                <option value="SI">Slovenia</option>\
                                <option value="SB">Solomon Islands</option>\
                                <option value="SO">Somalia</option>\
                                <option value="ZA">South Africa</option>\
                                <option value="GS">South Georgia and the South Sandwich Islands</option>\
                                <option value="ES">Spain</option>\
                                <option value="LK">Sri Lanka</option>\
                                <option value="SD">Sudan</option>\
                                <option value="SR">Suriname</option>\
                                <option value="SJ">Svalbard and Jan Mayen</option>\
                                <option value="SZ">Swaziland</option>\
                                <option value="SE">Sweden</option>\
                                <option value="CH">Switzerland</option>\
                                <option value="SY">Syrian Arab Republic</option>\
                                <option value="TW">Taiwan, Province of China</option>\
                                <option value="TJ">Tajikistan</option>\
                                <option value="TZ">Tanzania, United Republic of</option>\
                                <option value="TH">Thailand</option>\
                                <option value="TL">Timor-Leste</option>\
                                <option value="TG">Togo</option>\
                                <option value="TK">Tokelau</option>\
                                <option value="TO">Tonga</option>\
                                <option value="TT">Trinidad and Tobago</option>\
                                <option value="TN">Tunisia</option>\
                                <option value="TR">Turkey</option>\
                                <option value="TM">Turkmenistan</option>\
                                <option value="TC">Turks and Caicos Islands</option>\
                                <option value="TV">Tuvalu</option>\
                                <option value="UG">Uganda</option>\
                                <option value="UA">Ukraine</option>\
                                <option value="AE">United Arab Emirates</option>\
                                <option value="GB">United Kingdom</option>\
                                <option value="US">United States</option>\
                                <option value="UM">United States Minor Outlying Islands</option>\
                                <option value="UY">Uruguay</option>\
                                <option value="UZ">Uzbekistan</option>\
                                <option value="VU">Vanuatu</option>\
                                <option value="VE">Venezuela</option>\
                                <option value="VN">Viet Nam</option>\
                                <option value="VG">Virgin Islands, British</option>\
                                <option value="VI">Virgin Islands, U.S.</option>\
                                <option value="WF">Wallis and Futuna</option>\
                                <option value="EH">Western Sahara</option>\
                                <option value="YE">Yemen</option>\
                                <option value="ZM">Zambia</option>\
                                <option value="ZW">Zimbabwe</option>\
                            </select>';

                    }


                   function docollapse(thingstring) {
                       thing = document.getElementById(thingstring);

                       if (thing.style.height == '') {
                         //  thing.style.visibility = 'hidden';
                           thing.style.height = '0px';
                           thing.style.display = 'none';
                       } else {
                          // thing.style.visibility = 'visible'
                           thing.style.height = '';
                           thing.style.display = '';
                       }

                       fixtextfields() ;
                   }
               
                    function wplinkdisable() {
                         if(document.forms['form'].wplink_disable.checked==true){
                            document.form.wplink_disable_keyword.checked = true;
                            document.form.wplink_disable_link_matching.checked = true;
                            document.form.wplink_disable_links.checked = true;
                         } else {
                            if(document.form.wplink_disable_keyword.checked == true &&
                                document.form.wplink_disable_link_matching.checked == true &&
                                document.form.wplink_disable_links.checked == true)
                            {
                                document.form.wplink_disable_keyword.checked = false;
                                document.form.wplink_disable_link_matching.checked = false;
                                document.form.wplink_disable_links.checked = false;

                            }
                         }
                    }
                </script>

                <input type="checkbox" name="wplink_disable" value="1" onchange="javascript:wplinkdisable()" /> <strong>Disable WP Link Engine</strong><br />
                <input type="checkbox" name="wplink_disable_keyword" value="1" /> Disable keyword replacement.<br />
                <input type="checkbox" name="wplink_disable_link_matching" value="1" /> Disable link matching.<br />
                <input type="checkbox" name="wplink_disable_links" value="1" /> Disable all links.<br />
              
                </form>
         </div>

        <?php
    }
?>
