 
      <form method="post" name="contactFrm" id="<?php echo $formId; ?>">
            <input type="hidden" name="refpage"  value="<?php echo $PageName; ?>" />
            <input type="hidden" name="formsubject"  value="<?php echo $FormSubject; ?>" />
            <input type="hidden" name="formtitle"  value="<?php echo $FormTitle; ?>" />
            <input type="hidden" name="formcat"  value="<?php echo $FormCat; ?>" />
            <input type="hidden" name="pageid"  value="<?php echo $pageId; ?>" />

             <div class="card-layout card2-wrapper">

               <filedset id="field-one">

                <legend>Personal Info</legend>
                 
                 <div id="form-note">
                   <h4>* Required</h4>
                 </div>

                 <div class="card-layout card2-wrapper">

                   <div>

                      <label for="first" class="visually-hidden">First Name<span>*</span></label>
                      <input type="text" name="first" id="first" class="get-value" placeholder="First Name*" pattern="[A-Za
                      -z\s]{1,100}" title="Only letters are allowed." aria-required="true" maxlength="100" />

                      <label for="last" class="visually-hidden">Last Name<span>*</span></label>
                      <input type="text" name="last" id="last" class="get-value" placeholder="Last Name*" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" />

                      <label for="email" class="visually-hidden">Work Email Address<span>*</span></label>
                      <input type="email" name="email" class="get-value" id="email" placeholder="Work Email Address*" maxlength="100" autocomplete="off" />

                     
                        <label for="phone" class="visually-hidden">Phone</label>
                        <input type="tel" name="phone" id="phone" placeholder="Phone" maxlength="50" pattern="[0-9\(\)\-\s]+" title="Only valid phone numbers allowed." autocomplete="tel" />

                        <label for="zip-code-field" class="visually-hidden">Zip Code<span>*</span></label>
                        <input type="text" name="zip" id="zip-code-field" class="get-value" placeholder="Zip Code*" maxlength="20" pattern="[a-zA-Z0-9\-\s]+" title="Only valid zip codes are allowed." aria-required="true" />

                     </div>

                     <div>

                       <label for="organization" class="visually-hidden">Company Name<span>*</span></label>
                        <input type="text" name="organization" id="organization" class="get-value" placeholder="Company Name*" maxlength="100" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." aria-required="true" autocomplete="organization" />

                        <label for="job-title" class="visually-hidden">Job Title<span>*</span></label>
                        <input type="text" name="jobtitle" id="job-title" placeholder="Job Title" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." />

                        <label for="country" class="visually-hidden">Country<span>*</span></label>
                        <input type="text" name="country" id="country" class="get-value" placeholder="Country*" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" autocomplete="country-name" />

                        <label for="sample-number" class="visually-hidden">Estimated Sample Number</label>
                        <input type="text" name="sample-number" id="sample-number" placeholder="Estimated Sample Number" maxlength="10" pattern="[0-9\.]+" title="Only numbers allowed." />

                     </div>

                   </div>

               </filedset>

               <filedset>
                 
                 <div id="custom-library">

                    <div>
                      <label class="focus-area-of-custom-library">FOCUS AREA OF CUSTOM LIBRARY*</label>
                      <textarea name="focusarea" id="focus-area-of-custom-library" placeholder="Human allergens, tumor proteins, microbiome, etc." rows="1" cols="1" minlength="10" maxlength="799" aria-required="true" class="get-value"></textarea>
                    </div>

                    <div>
                      <label for="aprox-number-of-proteins">Approximate number of proteins in the custom library*</label>
                      <input type="text" name="aproxnumofproteins" id="aprox-number-of-proteins" maxlength="100" pattern="[0-9\.]+" />
                    </div>

                    <div class="select-box" id="hear-about">
                      <label for="how-did-you-hear-about-us">How did you hear about us?*</label>
                      <select name="foundout" id="how-did-you-hear-about-us">
                        <option value="0">Select One</option>
                        <option value="1">Referral</option>
                        <option value="2">Web search</option>
                        <option value="3">Google search ad</option>
                        <option value="4">Publication</option>
                        <option value="5">Social media</option>
                        <option value="6">CDI Labs email</option>
                        <option value="7">Event / meeting</option>
                        <option value="8">Other</option>
                      </select>
                    </div>

                  </div>

               </filedset>

             </div>

            <filedset id="submit-fieldset">

                <legend>Inquiry and Submit Info</legend>
                       
                 <div class="select-box" id="select-assay-goal">
                    <label for="assay-goal" class="visually-hidden">Assay Goal</label>
                    <select name="assay-goal" id="assay-goal">
                      <option value="0">Assay Goal (select one)</option>
                      <option value="1">Seromics (antibody responses and biomarkers)</option>
                      <option value="2">TargetID (determine binding target or specificity)</option>
                      <option value="3">Other</option>
                    </select>
                  </div>
                    
                  <label for="questions" class="visually-hidden">Questions / Requests</label>
                  <textarea name="questions" id="questions" placeholder="*Questions / Requests" rows="1" cols="1" minlength="10" maxlength="799" aria-required="true" class="get-value"></textarea>
                 
                 <div id="request-checkboxes" class="request-checkboxes">
                  <input type="checkbox" name="newsletters" id="newsletters" value="1" /><label for="newsletters">I would like to receive the latest news and updates from CDI Labs.</label>
                </div>

                  <p class="submit-consent">By clicking submit, you consent to allow CDI Labs to store and process the personal information submitted in order to provide you the content requested. Please refer to CDI Labs <a href="https://www.cdilabs.com/company/privacy-policy">Privacy Policy</a>.</p>
                
                <input type="submit" name="register" value="SUBMIT" class="global-btn blue-btn smooth-hover" id="register-btn" />

            </filedset>

        </form>
