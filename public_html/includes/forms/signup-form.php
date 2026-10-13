<form method="post" name="regFrm" id="<?php echo $formId; ?>">
  <input type="hidden" name="refpage" value="<?php echo $PageName; ?>" tabindex="0" />
  <input type="hidden" name="formsubject" value="<?php echo $FormSubject; ?>" />
  <input type="hidden" name="formtitle" value="<?php echo $FormTitle; ?>" />
  <input type="hidden" name="formcat" value="<?php echo $FormCat; ?>" />
  <input type="hidden" name="pageid" value="<?php echo $pageId; ?>" />

  <div id="<?php echo $formId; ?>-form-note">
    <h4>* Required</h4>
  </div>

  <div class="card-layout">

    <fieldset id="field-one">

      <legend>Personal Info</legend>

      <div class="card-layout card2-wrapper">
        <div>
          <label for="first" class="visually-hidden">First Name<span>*</span></label>
          <input type="text" name="firstname" id="first" class="get-value" placeholder="First Name*" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" maxlength="100" tabindex="1" />

          <label for="last" class="visually-hidden">Last Name<span>*</span></label>
          <input type="text" name="lastname" id="last" class="get-value" placeholder="Last Name*" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" tabindex="2" />

          <label for="email" class="visually-hidden">Work Email Address<span>*</span></label>
          <input type="email" name="email" class="get-value" id="email" placeholder="Work Email Address*" maxlength="100" autocomplete="off" tabindex="3" />

          <label for="phone" class="visually-hidden">Phone</label>
          <input type="tel" name="phone" id="phone" placeholder="Phone" maxlength="50" pattern="[0-9\(\)\-\s]+" title="Only valid phone numbers allowed." autocomplete="tel" tabindex="5" />

          <label for="zip-code-field" class="visually-hidden">Zip Code<span>*</span></label>
          <input type="text" name="zip" id="zip-code-field" class="get-value" placeholder="Zip Code*" minlength="2" maxlength="20" pattern="[a-zA-Z0-9\-\s]+" title="Only valid zip codes are allowed." aria-required="true" />
        </div>
        <div>
          <label for="company" class="visually-hidden">Company Name<span>*</span></label>
          <input type="text" name="company" id="company" class="get-value" placeholder="Company Name*" maxlength="100" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." aria-required="true" autocomplete="company" tabindex="4" />

          <label for="job-title" class="visually-hidden">Job Title<span>*</span></label>
          <input type="text" name="jobtitle" id="job-title" placeholder="Job Title" maxlength="100" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." />

          <label for="country" class="visually-hidden">Country<span>*</span></label>
          <input type="text" name="country" id="country" class="get-value" placeholder="Country*" maxlength="100" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" autocomplete="country-name" tabindex="6" />
        </div>
      </div>

    </fieldset>

  </div>

  <fieldset id="signup-submit">

    <legend>Submit Info</legend>

    <p class="submit-consent">By clicking submit, you consent to allow CDI Labs to store and process the personal information submitted in order to provide you the content requested. Please refer to CDI Labs <a href="/company/privacy-policy">Privacy Policy</a>.</p>

    <input type="submit" name="signup" value="SUBMIT" class="global-btn smooth-hover" id="signup-btn" tabindex="9" />

  </fieldset>

</form>