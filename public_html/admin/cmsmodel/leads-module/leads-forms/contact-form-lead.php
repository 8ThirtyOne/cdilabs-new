<form method="post" name="grantFrm" id="enter-data">
             <input type="hidden" name="pkid"  value="<?php echo $pkid; ?>" />

            <fieldset>
                <label for="First Name">First Name</label>
                <input type="text" name="first" id="first"
                    <?php
                      echo 'value="'.htmlentities($ViewData["firstname"]).'"';
                    ?> tabindex="9" />
            </fieldset>

            <fieldset>
                <label for="Last Name">Last Name</label>
                <input type="text" name="last" id="last"
                    <?php
                      echo 'value="'.htmlentities($ViewData["lastname"]).'"';
                    ?> tabindex="10" />
            </fieldset>

            <fieldset>
            <label for="Email Address">Email Address</label>
                <input type="email" name="email" class="get-value" id="email" 
                    <?php
                      echo 'value="'.htmlentities($ViewData["email"]).'"';
                    ?> tabindex="2" />
            </fieldset>

            <fieldset>
            <label for="Company / Organization">Company / Organization</label>
            <input type="text" name="organization" id="organization"
                  <?php
                  echo 'value="'.htmlentities($ViewData["company"]).'"';
                  ?> tabindex="11" />
            </fieldset>

            <fieldset>
            <label for="Zip">Zip</label>
            <input type="text" name="zip" id="zip"
             <?php 
                  echo 'value="'.htmlentities($ViewData["zip"]).'"';
             ?> tabindex="15" />
            </fieldset>

            <fieldset>
            <label for="Country">Country</label>
            <input type="text" name="country" id="country"
                <?php
                  echo 'value="'.htmlentities($ViewData["country"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="Country">Phone</label>
            <input type="text" name="phone" id="phone"
                <?php
                  echo 'value="'.htmlentities($ViewData["phone"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="Estimated Sample Number">Estimated Sample Number</label>
            <input type="text" name="sample-num" id="sample-num"
                <?php
                  $sampleNum = $ViewData["sample_num"] > 0 ? $ViewData["sample_num"] : 'none';
                    echo "value=$sampleNum";
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="Platform">Platform of Interest</label>
            <input type="text" name="platform" id="platform"
                <?php
                  echo 'value="'.htmlentities($ViewData["platform"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="Assay Goal">Assay Goal</label>
            <input type="text" name="assay-goal" id="assay-goal"
                <?php
                  echo 'value="'.htmlentities($ViewData["assay_goal"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
                 <label for="Inquiry">Inquiry</label>
                   <textarea name="inquiry" id="inquiry" rows="1" cols="1" tabindex="9"><?php if($ViewData['inquiry'] != 'none') echo stripcslashes($ViewData['inquiry']); ?></textarea>
            </fieldset>

            <fieldset>
            <label for="How did you hear about us">How did you hear about us?</label>
            <input type="text" name="found-out" id="found-out"
                <?php
                  echo 'value="'.htmlentities($ViewData["heard_from"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="Referrer Page">Referrer Page</label>
            <input type="text" name="referrer" id="referrer"
                <?php
                  echo 'value="'.htmlentities($ViewData["referrer"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
                <br />
                <h4>I would like to receive the latest news and updates from CDI Labs:
                <?php $news = $ViewData["newsletter"] == 1 ? 'YES' : 'NO'; echo "<span>$news</span>"; ?>
            </fieldset>

            <fieldset id="user-submit">
                
            </fieldset>

        </form>
