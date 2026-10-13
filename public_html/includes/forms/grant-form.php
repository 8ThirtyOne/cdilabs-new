
      <form method="post" name="promoFrm" id="<?php echo $formId; ?>">
            <input type="hidden" name="refpage"  value="<?php echo $PageName; ?>" />
            <input type="hidden" name="formsubject"  value="<?php echo $FormSubject; ?>" />
            <input type="hidden" name="formtitle"  value="<?php echo $FormTitle; ?>" />
            <input type="hidden" name="formcat"  value="<?php echo $FormCat; ?>" />
            <input type="hidden" name="pageid"  value="<?php echo $pageId; ?>" />

         <div class="card-layout card2-wrapper">

             <fieldset id="field-one">

                <legend>Personal Info</legend>

                <div id="form-note">
                    <h4>* Required</h4>
                </div>

                <div class="card-layout card4-wrapper">

                <div>

                  <label for="first" class="visually-hidden">First Name<span>*</span></label>
                  <input type="text" name="first" id="first" class="get-value" placeholder="First Name*" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" maxlength="100" />

                  <label for="last" class="visually-hidden">Last Name<span>*</span></label>
                  <input type="text" name="last" id="last" class="get-value" placeholder="Last Name*" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" />

                  <label for="email" class="visually-hidden">Work Email Address<span>*</span></label>
                  <input type="email" name="email" class="get-value" id="email" placeholder="Work Email Address*" maxlength="100" autocomplete="off" />

                </div>

                <div>

                  <label for="organization" class="visually-hidden">Company / Organization<span>*</span></label>
                  <input type="text" name="organization" id="organization" class="get-value" placeholder="Company / Organization*" maxlength="100" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." aria-required="true" autocomplete="organization" />

                  <label for="job-function" class="visually-hidden">Job Function*<span>*</span></label>
                  <input type="text" name="jobfunction" id="job-function" placeholder="Job Function*" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" class="get-value" />

                  <label for="country" class="visually-hidden">Country<span>*</span></label>
                  <input type="text" name="country" id="country" class="get-value" placeholder="Country*" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" autocomplete="country-name" />

                </div>

                <div>

                  <div class="select-box" id="product-choice">
                    <label for="product-of-choice">PRODUCT OF CHOICE*</label>
                    <select name="productchoice" id="product-of-choice">
                      <option value="0">Select One</option>
                      <option value="1">HuProt&trade; Proteome Microarray</option>
                      <option value="2">VirScan&reg; PhIP-Seq</option>
                      <option value="3">HuScan&reg; PhIP-Seq</option>
                      <option value="4">MouseScan&trade; PhIP-Seq</option>
                      <option value="5">VirD&trade; Membrane Protein</option>
                    </select>
                  </div>

                  <div class="select-box" id="sample-avail">
                    <label for="sample-availability">SAMPLE AVAILABILITY*</label>
                    <select name="sampleavail" id="sample-availability">
                      <option value="0">Select One</option>
                      <option value="1">Now</option>
                      <option value="2">by August 30 (submission deadline)</option>
                      <option value="3">within 30 days after August 30</option>
                      <option value="4">within 60 days after August 30</option>
                      <option value="4">Other</option>
                    </select>
                  </div>

                </div>

                <div class="checkboxes-wrapper">

                   <p class="fieldset-heading">SAMPLE TYPE*</p>

                   <div class="checkbox-div">
                  
                     <div class="request-checkboxes">

                      <input type="checkbox" name="sampletype[]" value="Plasma" id="plasma" /><label for="plasma">Plasma</label>

                      </div>

                      <div class="request-checkboxes">

                        <input type="checkbox" name="sampletype[]" value="Serum" id="serum" /><label for="serum">Serum</label>

                      </div>

                      <div class="request-checkboxes">

                        <input type="checkbox" name="sampletype[]" value="RNA" id="rna" /><label for="rna">RNA</label>

                      </div>

                   </div>

                   <div class="checkbox-div">
                  
                     <div class="request-checkboxes">

                      <input type="checkbox" name="sampletype[]" value="Antibody Isolates" id="antibody-isolates" /><label for="antibody-isolates">Antibody Isolates</label>

                      </div>

                      <div class="request-checkboxes">

                        <input type="checkbox" name="sampletype[]" value="Cerebrospinal Fluid" id="cerebrospinal-fluid" /><label for="cerebrospinal-fluid">Cerebrospinal Fluid</label>

                      </div>

                      <div class="request-checkboxes">

                        <input type="checkbox" name="sampletype[]" value="Other" id="other" /><label for="other">Other</label>

                      </div>

                   </div>

                </div>

              </div>


            </fieldset>

            
            <fieldset>
            <legend>Project Info</legend>

            <p class="fieldset-heading">DESCRIBE YOUR PROJECT</p>

            <label for="abstract" class="visually-hidden">Abstract Title*</label>
            <textarea name="abstract" id="abstract" class="get-value" placeholder="Abstract Title*" rows="1" cols="1" minlength="10" maxlength="500" aria-required="true"></textarea>
            <p id="abstract-count">Characters: <span id="charength">0</span>/500</p>
              
            <label for="project-description" class="visually-hidden">Project Description*</label>
            <textarea name="projectdesc" id="project-description" class="get-value" placeholder="Project Description*" rows="1" cols="1" minlength="10" maxlength="10000"aria-required="true"></textarea>
            <p id="desc-count">Characters: <span id="charength">0</span>/10000</p>

            </fieldset>

        </div>

        <filedset id="submit-fieldset">

            <legend>Submit Info</legend>

            <div id="request-checkboxes" class="request-checkboxes">
              <input type="checkbox" name="processdata" id="process-data" value="1" /><label for="process-data">* All grant applicants agree that CDI Labs may process the personal data he or she provides as part of the application in accordance with CDI Labs privacy policies.</label>
            </div>

            <div id="request-checkboxes" class="request-checkboxes">
              <input type="checkbox" name="newsletters" id="newsletters" value="1" /><label for="newsletters">I would like to sign up to receive CDI Labs newsletters.</label>
            </div>
            
            <input type="submit" name="register" value="SUBMIT" class="global-btn smooth-hover" id="register-btn" />

        </filedset>

        <filedset id="form-disclaimer">
          <p><small>* No purchase necessary. This promotion is available only to life science or research professionals 21 years or older in the U.S. (excluding Puerto Rico) and Canada who are able to submit a completed survey. <span class="bold">Healthcare professionals may not participate in this promotion.</span> Completed entries must be received by CDI Labs no later than September 27, 2024. By submitting this form, you acknowledge that you are not prohibited by employment, contract, law, or any applicable professional code of conduct from accepting a gift from CDI Labs or otherwise participating in the promotion. You grant CDI Labs the right to use any information provided via the submission process. Offer void where prohibited, licensed, or otherwise restricted by federal, state, provincial, or local laws or regulation or agency/institutional policy. CDI Labs will determine the promotion winner and related beneficiaries in its sole discretion. Other restrictions may apply. CDI Labs products and services are intended and marketed solely for research purposes; not for use in any clinical or diagnostic purposes. Use of any CDI Labs products or services provided in connection with this promotion will be subject to CDI Labs’ standard terms and conditions. By submitting this form, you agree to our <a href="/company/privacy-policy" class="bold smooth-hover">privacy policies.</a></small></p>
        </filedset>

    </form>
