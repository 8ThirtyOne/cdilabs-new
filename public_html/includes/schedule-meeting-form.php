                 <form method="post" name="eventsFrm" id="events-form">

                      <fieldset>
                          <label for="full-name" class="visually-hidden">Full Name*</label>
                          <input type="text" name="fullname" placeholder="Full Name*" id="full-name" class="get-value" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." aria-required="true" maxlength="100" />
                      </fieldset>

                      <fieldset>
                          <label for="job-title" class="visually-hidden">Job Title/Role</label>
                          <input type="text" name="jobtitle" placeholder="Job Title/Role" id="job-title" pattern="[A-Za-z\s]{1,100}" title="Only letters are allowed." maxlength="100" />
                      </fieldset>

                      <fieldset>
                          <label for="instituion" class="visually-hidden">Organization / Institution*</label>
                          <input type="text" name="instituion" id="instituion" class="get-value" placeholder="Organization / Institution*" maxlength="100" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." aria-required="true" autocomplete="instituion" />
                      </fieldset>

                      <fieldset>
                          <label for="email" class="visually-hidden">Email*</label>
                          <input type="email" name="email" value="" placeholder="Email*" id="email" class="get-value" maxlength="100" />
                      </fieldset>

                      <fieldset>
                      <label for="phone" class="visually-hidden">Phone</label>
                          <input type="tel" name="phone" id="phone" placeholder="Phone" maxlength="50" pattern="[0-9\(\)\-\s]+" title="Only valid phone numbers allowed." autocomplete="tel" />
                      </fieldset>

                      <fieldset>
                      <label for="which-event" class="visually-hidden">Event or Meeting Name*</label>
                          <input type="tel" name="whichevent" id="which-event" placeholder="Event or Meeting Name*" class="get-value" maxlength="100" />
                      </fieldset>

                      <label for="questions" class="visually-hidden">Questions or requests?</label>
                        <textarea name="questions" id="questions" placeholder="Questions or requests?" rows="1" cols="1" minlength="10" maxlength="799"></textarea>

                      <fieldset>
                        <input type="submit" name="submit" class="global-btn blue-btn smooth-hover" id="submit-btn" value="SUBMIT" />
                      </fieldset>

                    </form>
