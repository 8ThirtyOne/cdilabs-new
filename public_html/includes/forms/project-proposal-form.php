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

                </div>

            </fieldset>

            <fieldset id="question-1" class="textBox">

                <legend>Project Name</legend>
                
                <label for="service-feedback"><span>* 1.</span>Project Name:</label>
                <input type="text" name="projectname" id="project-name" class="get-value" minlength="1" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" tabindex="3"/>

            </fieldset>
            
            <fieldset id="question-2" class="textBox">

                <legend>Project Description</legend>
                
                <label for="service-feedback"><span>* 2.</span>Brief outline of proposed project and/or potential product or service.</label>
                 <textarea name="servicefeedback" id="service-feedback" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="6"></textarea>

            </fieldset>

            <fieldset class="request-checkboxes survey-radios" id="question-3">

                <legend>Partners Involved</legend>

                <label for="data-analysis"><span>* 3.</span>Does this project involve partners?</label>
                <div class="full-w-radios">
                    <div>
                    <input type="radio" name="partners" id="partners-yes" value="1" tabindex="7" /><label for="YES">YES</label>
                    </div>
                    <div>
                    <input type="radio" name="partners" value="2" id="partners-no" tabindex="8" /><label for="NO">NO</label>
                    </div>
                </div>
                <label for="service-feedback">If so, please list them and provide a brief description of what they will do and/or what they are providing.</label>
                 <textarea name="servicefeedback" id="service-feedback" rows="1" cols="1" minlength="1" maxlength="2000" aria-required="true" class="get-value" tabindex="6"></textarea>
                 
            </fieldset>

            <fieldset id="question-4" class="textBox">

                <legend>Target Customer</legend>
                
                <label for="service-feedback"><span>* 4.</span>Target customer</label>
                <p>Segment, disease area, etc., as applicable (essentially, who will care?)</p>
                 <textarea name="servicefeedback" id="service-feedback" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="6"></textarea>

            </fieldset>

            <fieldset id="question-5" class="textBox">

                <legend>Value Proposition</legend>
                
                <label for="service-feedback"><span>* 5.</span>Brief value proposition</label>
                <p>What customer problem does this development ultimately solve (essentially, why will they care?)</p>
                 <textarea name="servicefeedback" id="service-feedback" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="6"></textarea>

            </fieldset>

            <fieldset class="request-checkboxes survey-radios" id="question-6">

                <legend>Complement CDI Labs</legend>

                <label for="data-analysis"><span>* 6.</span>Does the potential product or service complement CDI Labs' existing portfolio, and if so, how?</label>
                <div class="full-w-radios">
                    <div>
                    <input type="radio" name="dataanalysis" id="data-analysis-yes" value="1" tabindex="7" /><label for="YES">YES</label>
                    </div>
                    <div>
                    <input type="radio" name="dataanalysis" value="2" id="data-analysis-no" tabindex="8" /><label for="NO">NO</label>
                    </div>
                </div>
                
                <label for="service-feedback">If so, how?</label>
                 <textarea name="servicefeedback" id="service-feedback" rows="1" cols="1" minlength="1" maxlength="2000" aria-required="true" class="get-value" tabindex="6"></textarea>
                 
            </fieldset>

            <fieldset id="question-7" class="textBox">

                <legend>Market Opportunity</legend>
                
                <label for="service-feedback"><span>* 7.</span>Market opportunity estimate</label>
                <p>Just small/medium/large versus our current revenue is sufficient if that’s all you have (no need for a mini market analysis project).</p>
                 <textarea name="servicefeedback" id="service-feedback" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="6"></textarea>

            </fieldset>

            <fieldset id="question-8" class="textBox">

                <legend>Competitors</legend>
                
                <label for="service-results"><span>* 8.</span>Is there another product/company that would be considered a direct competitor if CDI commercialized a product/service based on this development?</label>
                 <textarea name="serviceresults" id="service-results" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="11"></textarea>
 
            </fieldset>
            
            <fieldset id="question-9" class="textBox">

                <legend>Additional Resources</legend>
                
                <label for="service-results"><span>* 9.</span>List key material and external resources needed</label>
                <p>(Rough estimate of key cost drivers, <i>i.e.</i>, 50 arrays and this sized oligo pool).</p>
                 <textarea name="serviceresults" id="service-results" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="11"></textarea>

            </fieldset>
            
            <fieldset id="question-10" class="textBox">

                <legend>Headcount</legend>
                
                <label for="service-results"><span>* 10.</span>Headcount commitment</label>
                <p>(Rough estimate, <i>i.e.</i>, 8 hours design time and 10 hours of wet lab time, if specific people/skills are needed please highlight that as well).</p>
                 <textarea name="serviceresults" id="service-results" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="11"></textarea>

            </fieldset>
            
            <fieldset id="question-11" class="textBox">

                <legend>How Long</legend>
                
                <label for="service-results"><span>* 11.</span>How long will the initial experiments take if resourced and funded?</label>
                 <textarea name="serviceresults" id="service-results" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="11"></textarea>

            </fieldset>
            
            <fieldset id="question-12" class="textBox">

                <legend>Success</legend>
                
                <label for="service-results"><span>* 12.</span>Briefly assess the difficulty of the project (likelihood of success).</label>
                 <textarea name="serviceresults" id="service-results" rows="1" cols="1" minlength="1" maxlength="1000" aria-required="true" class="get-value" tabindex="11"></textarea>

            </fieldset>


            <filedset id="survey-submit">

                <legend>Submit Info</legend>
                
                <input type="submit" name="submit" value="SUBMIT" class="global-btn smooth-hover" id="submit-btn" tabindex="15" />

            </filedset>

        </form>


