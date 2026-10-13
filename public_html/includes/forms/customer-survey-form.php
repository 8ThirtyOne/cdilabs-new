        <form method="post" name="surveyFrm" id="<?php echo $formId; ?>">
            <input type="hidden" name="refpage" value="<?php echo $PageName; ?>" tabindex="0" />
            <input type="hidden" name="formsubject"  value="<?php echo $FormSubject; ?>" />
            <input type="hidden" name="formtitle"  value="<?php echo $FormTitle; ?>" />
            <input type="hidden" name="formcat"  value="<?php echo $FormCat; ?>" />
            <input type="hidden" name="pageid"  value="<?php echo $pageId; ?>" />

            <svg class='hide-it'>
            <symbol id="star-off" viewBox="0 0 36 36"><path d="M18,36C8.07,36,0,27.92,0,18S8.07,0,18,0s18,8.07,18,18-8.07,18-18,18ZM18,1.71C9.02,1.71,1.71,9.02,1.71,18s7.31,16.29,16.29,16.29,16.29-7.31,16.29-16.29S26.98,1.71,18,1.71Z"/></symbol>
             <symbol id="star-on" viewBox="0 0 36 36"><path class="cls-1" d="M18,36C8.07,36,0,27.92,0,18S8.07,0,18,0s18,8.07,18,18-8.07,18-18,18Z"/></symbol>
            </svg>

            <div id="form-note">
                <h3>Please <em>FILL OUT ALL FIELDS</em> in the form below and submit.</h3>
                <h4>* Required</h4>
            </div>

            <fieldset id="user-info">

                <legend>Personal Info</legend>

                <div class="form-2col">

                  <label for="first" class="visually-hidden">First Name<span>*</span></label>
                  <input type="text" name="first" id="first" class="get-value" placeholder="First Name*" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" minlength="1" maxlength="100" tabindex="1" />

                  <label for="last" class="visually-hidden">Last Name<span>*</span></label>
                  <input type="text" name="last" id="last" class="get-value" placeholder="Last Name*" minlength="1" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" tabindex="2"/>

                  <label for="email" class="visually-hidden">Work Email Address<span>*</span></label>
                  <input type="email" name="email" class="get-value" id="email" placeholder="Work Email Address*" minlength="1" maxlength="250" autocomplete="off" tabindex="3" />

                  <label for="company" class="visually-hidden">Company Name<span>*</span></label>
                  <input type="text" name="company" id="company" class="get-value" placeholder="Company Name*" minlength="1" maxlength="100" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." aria-required="true" autocomplete="company" tabindex="4" />

                  <label for="job-title" class="visually-hidden">Job Title<span>*</span></label>
                  <input type="text" name="jobtitle" id="job-title" placeholder="Job Title*" class="get-value" minlength="1" maxlength="100" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." aria-required="true" autocomplete="job-title" tabindex="5" />

                </div>

             </fieldset>

             <fieldset id="question-1">

                <input type="hidden" name="projectsatisfy" class="get-value" value="" />

                <legend>Project Satisfaction Rating</legend>

                 <p><span>* 1.</span> What is your overall satisfaction level working with CDI Labs on your latest project?</p>
                 <ul class="star-rating" id="project-satisfaction">
                    <li>Very Negative <span>|</span></li>
                    <?php 
                        for($i=1;$i<11;$i++){
                            $digit = $i < 10 ? 'sd-num' : 'dd-num';
                            echo "<li data-num='$i'><svg class='star-icon'><use xlink:href='#star-off' /></svg><em class='$digit'>$i</em></li>";
                        }
                    ?>
                    <li><span>|</span> Very Positive</li>
                 </ul>

            </fieldset>

            <fieldset id="question-2" class="textBox">

                <legend>Areas of Service Rating</legend>
                
                <label for="service-feedback"><span>* 2.</span>Please provide additional feedback regarding the aspects of the service with which you were particularly satisfied or dissatisfied.</label>
                 <textarea name="servicefeedback" id="service-feedback" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="6"></textarea>
                 <p class="word-count">Characters: <em id="charength">0</em>/1000</p>

            </fieldset>

            <fieldset id="question-3">

                <input type="hidden" name="onboarding" class="get-value" value="" />

                <legend>Onboarding / Sample Submission Rating</legend>

                 <p><span>* 3.</span>How would you rate the onboarding / sample submission process?</p>
                 <ul class="star-rating" id="onboarding">
                    <li>Very Negative <span>|</span></li>
                    <?php 
                        for($i=1;$i<11;$i++){
                            $digit = $i < 10 ? 'sd-num' : 'dd-num';
                            echo "<li data-num='$i'><svg class='star-icon'><use xlink:href='#star-off' /></svg><em class='$digit'>$i</em></li>";
                        }
                    ?>
                    <li><span>|</span> Very Positive</li>
                 </ul>

            </fieldset>

            <fieldset id="question-4">

                <input type="hidden" name="timeliness" class="get-value" value="" />

                <legend>Timeliness Rating</legend>

                 <p><span>* 4.</span>How would you rate the timeliness of receiving results from our service?</p>
                 <ul class="star-rating" id="timeliness">
                    <li>Very Negative <span>|</span></li>
                    <?php 
                        for($i=1;$i<11;$i++){
                            $digit = $i < 10 ? 'sd-num' : 'dd-num';
                            echo "<li data-num='$i'><svg class='star-icon'><use xlink:href='#star-off' /></svg><em class='$digit'>$i</em></li>";
                        }
                    ?>
                    <li><span>|</span> Very Positive</li>
                 </ul>

            </fieldset>

            <fieldset id="question-5">

                <input type="hidden" name="quality" class="get-value" value="" />

                <legend>Quality Rating</legend>

                 <p><span>* 5.</span>How satisfied are you with the quality of, and information contained in, the data reports provided as part of our service?</p>
                 <ul class="star-rating" id="quality">
                    <li>Not Satisfied <span>|</span></li>
                    <?php 
                        for($i=1;$i<11;$i++){
                            $digit = $i < 10 ? 'sd-num' : 'dd-num';
                            echo "<li data-num='$i'><svg class='star-icon'><use xlink:href='#star-off' /></svg><em class='$digit'>$i</em></li>";
                        }
                    ?>
                    <li><span>|</span> Very Satisfied</li>
                 </ul>

            </fieldset>

            <fieldset class="request-checkboxes survey-radios" id="question-6">

                <legend>Quality Rating</legend>

                <label for="data-analysis"><span>* 6.</span>Would you be interested in additional data analysis services?</label>
                <div>
                <input type="radio" name="dataanalysis" id="data-analysis-yes" value="1" tabindex="7" /><label for="YES">YES</label>
                </div>
                <div>
                <input type="radio" name="dataanalysis" value="2" id="data-analysis-no" tabindex="8" /><label for="NO">NO</label>
                </div>
                 
            </fieldset>

            <fieldset id="question-7">

                <input type="hidden" name="serviceinquires" class="get-value" value="" />

                <legend>Service Inquires / Issues Rating</legend>

                 <p><span>* 7.</span>How responsive and helpful have you found our team in addressing your inquires or issues related to our service?</p>
                 <ul class="star-rating" id="service-inquires">
                    <li>Not Responsive <span>|</span></li>
                    <?php 
                        for($i=1;$i<11;$i++){
                            $digit = $i < 10 ? 'sd-num' : 'dd-num';
                            echo "<li data-num='$i'><svg class='star-icon'><use xlink:href='#star-off' /></svg><em class='$digit'>$i</em></li>";
                        }
                    ?>
                    <li><span>|</span> Very Responsive</li>
                 </ul>

            </fieldset>

            <fieldset id="question-8">

                <input type="hidden" name="recommendation" class="get-value" value="" />

                <legend>Recommendation Rating</legend>

                 <p><span>* 8.</span>How likely are you to recommend our proteomics service to others in your field?</p>
                 <ul class="star-rating" id="recommendation">
                    <li>Highly Unlikely <span>|</span></li>
                    <?php 
                        for($i=0;$i<11;$i++){
                            $digit = $i < 10 ? 'sd-num' : 'dd-num';
                            echo "<li data-num='$i'><svg class='star-icon'><use xlink:href='#star-off' /></svg><em class='$digit'>$i</em></li>";
                        }
                    ?>
                    <li><span>|</span> Highly Likely</li>
                 </ul>

            </fieldset>

            <fieldset id="question-9" class="textBox">

                <legend>Additional Studies</legend>
                
                <label for="additional-studies"><span>* 9.</span>Will your research need additional studies on our platforms, such as the same service with a larger sample number, validation services (fewer targets/more samples) or a different service offering?</label>
                 <textarea name="additionalstudies" id="additional-studies" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="9"></textarea>
                 <p class="word-count">Characters: <em id="charength">0</em>/1000</p>

            </fieldset>

            <fieldset id="question-10" class="textBox">

                <legend>Any new products or Services?</legend>
                
                <label for="service-feedback"><span>* 10.</span>Are there any new products or services that you think CDI Labs should consider offering?</label>
                 <textarea name="newprodservices" id="new-prodservices" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="10"></textarea>
                 <p class="word-count">Characters: <em id="charength">0</em>/1000</p>

            </fieldset>

            <fieldset id="question-11" class="textBox">

                <legend>Results from Services</legend>
                
                <label for="service-results"><span>* 11.</span>If you are able to share, how do you think that the results from these services will further your research?</label>
                 <textarea name="serviceresults" id="service-results" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="11"></textarea>
                 <p class="word-count">Characters: <em id="charength">0</em>/1000</p>

            </fieldset>

            <fieldset class="request-checkboxes survey-radios" id="question-12">

                <legend>Share your Feedback</legend>

                <label for="share-feedback"><span>* 12.</span>Would you consider allowing us to share your feedback in our marketing materials (including social media, web, and collateral)? If yes, we will conatct you to discuss specifics before using your feedback.</label>
                <div>
                <input type="radio" name="sharefeedback" id="share-feedback-yes" value="1" tabindex="12" /><label for="YES">YES</label>
                </div>
                <div>
                <input type="radio" name="sharefeedback" id="share-feedback-no" value="2" tabindex="13" /><label for="NO">NO</label>
                </div>
                 
            </fieldset>

            <filedset id="survey-submit">

                <legend>Submit Info</legend>

                <p>CDI Labs is commited to protect and respect your privacy, and we will only use your information to administer your account and to provide products and services you requested from us. From time to time, we would like to contact you about our products and services, as well as other content that may be of interest to you.</p>
                 
                 <div class="request-checkboxes">
                  <input type="checkbox" name="newsupdates" id="newsupdates" value="1" tabindex="14" /><label for="newsupdates">I would like to receive the latest news and updates from CDI Labs.</label>
                </div>

                  <p class="submit-consent">By clicking submit, you consent to allow CDI Labs to store and process the personal information submitted in order to provide you the content requested. Please refer to CDI Labs <a href="/company/privacy-policy">Privacy Policy</a>.</p>
                
                <input type="submit" name="submit" value="SUBMIT" class="global-btn smooth-hover" id="submit-btn" tabindex="15" />

            </filedset>

        </form>


