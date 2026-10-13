        <form method="post" name="surveyFrm" class="long-form" id="<?php echo $formId; ?>">
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
                <h3>We value your feedback, as it is instrumental in helping us refine and enhance the quality of our products, services and support. We kindly ask that you take a few moments to share your thoughts with us.</h3>
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

                 <p><span>* 1.</span> What is your overall satisfaction level with CDI Labs?</p>
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
                
                <label for="service-feedback"><span>* 2.</span>In 2–3 sentences, please share your experience working with CDI Labs.</label>
                 <textarea name="servicefeedback" id="service-feedback" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="6"></textarea>
                 <p class="word-count">Characters: <em id="charength">0</em>/1000</p>

            </fieldset>

            <fieldset id="question-8">

                <input type="hidden" name="recommendation" class="get-value" value="" />

                <legend>Recommendation Rating</legend>

                 <p><span>* 3.</span>How likely are you to recommend CDI Labs?</p>
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

            <fieldset class="request-checkboxes survey-radios" id="question-12">

                <legend>Share your Feedback</legend>

                <label for="share-feedback"><span>* 4.</span>Will you allow us to share your feedback (and use your company logo) in our marketing materials? (<i>i.e.</i>, social media, web, and collateral)</label>
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


