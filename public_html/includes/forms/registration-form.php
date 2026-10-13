<form method="post" name="regFrm" id="<?php echo $formId; ?>">
       <input type="hidden" name="refpage" value="<?php echo $ViewData['title']; ?>" tabindex="0" />
      <input type="hidden" name="formsubject"  value="<?php echo $FormSubject; ?>" />
      <input type="hidden" name="formtitle"  value="<?php echo $FormTitle; ?>" />
      <input type="hidden" name="formcat"  value="<?php echo $FormCat; ?>" />
      <input type="hidden" name="pageid"  value="<?php echo $pageId; ?>" />

               <div id="form-note">
                    <h3>Please share a few details about yourself.</h3>

                    <h4>* Required</h4>
               </div>

               <div class="card-layout card2-wrapper">

                 <fieldset id="field-one">

                    <legend>Personal Info</legend>

                    <div class="form-2col">

                      <label for="first" class="visually-hidden">First Name<span>*</span></label>
                      <input type="text" name="firstname" id="first" class="get-value" placeholder="First Name*" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" maxlength="100" tabindex="1" />

                      <label for="last" class="visually-hidden">Last Name<span>*</span></label>
                      <input type="text" name="lastname" id="last" class="get-value" placeholder="Last Name*" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" tabindex="2"/>

                      <label for="email" class="visually-hidden">Work Email Address<span>*</span></label>
                      <input type="email" name="email" class="get-value" id="email" placeholder="Work Email Address*" maxlength="100" autocomplete="off" tabindex="3" />

                      <label for="organization" class="visually-hidden">Company Name<span>*</span></label>
                      <input type="text" name="organization" id="organization" class="get-value" placeholder="Company Name*" maxlength="100" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." aria-required="true" autocomplete="organization" tabindex="4" />

                      <label for="phone" class="visually-hidden">Phone</label>
                        <input type="tel" name="phone" id="phone" placeholder="Phone" maxlength="50" pattern="[0-9\(\)\-\s]+" title="Only valid phone numbers allowed." autocomplete="tel" tabindex="5" />

                      <label for="country" class="visually-hidden">Country<span>*</span></label>
                      <input type="text" name="country" id="country" class="get-value" placeholder="Country*" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" autocomplete="country-name" tabindex="6" />

                    </div>

                 </fieldset>

                 <fieldset id="reg-inquiry">

                    <legend>Questions Field</legend>
                      
                    <label for="questions" class="visually-hidden">Questions / Requests</label>
                    <textarea name="questions" id="questions" placeholder="Questions / Requests" rows="1" cols="1" minlength="10" maxlength="799" tabindex="7"></textarea>

                </fieldset>

              </div>

                <fieldset id="reg-submit">

                    <legend>Submit Info</legend>

                    <p id="register-note">CDI Labs is committed to protect and respect your privacy, and we will only use your personal information to administer your account and to provide the products and services you requested from us. From time to time we would like to contact you about our products and services, as well as other content that might be of interest to you. </p>
                      
                    <div id="request-checkboxes" class="request-checkboxes">
                      <input type="checkbox" name="newsletters" id="newsletters" value="1" /><label for="newsletters" tabindex="8">I would like to receive the latest news and updates from CDI Labs.</label>
                    </div>

                      <p id="register-privacy">By clicking submit, you consent to allow CDI Labs to store and process the personal information submitted in order to provide you the content requested. Please refer to CDI Labs <a href="/company/privacy-policy">Privacy Policy</a>.</p>
                    
                    <input type="submit" name="register" value="SUBMIT" class="global-btn smooth-hover" id="register-btn" tabindex="9" />

                </fieldset>

          </form>
