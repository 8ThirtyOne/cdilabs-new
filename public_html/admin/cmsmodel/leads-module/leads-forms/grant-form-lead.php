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
            <label for="Job Function">Job Function</label>
            <input type="text" name="jobfunction" id="jobfunction"
             <?php 
                  echo 'value="'.htmlentities($ViewData["jobtitle"]).'"';
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
            <label for="Product of Choice">Product of Choice</label>
            <input type="text" name="product" id="product"
                <?php
                  echo 'value="'.htmlentities($ViewData["product"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="Sample Availability">Sample Availability</label>
            <input type="text" name="sample-avail" id="sample-avail"
                <?php
                  echo 'value="'.htmlentities($ViewData["sampleavail"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="Sample Type">Sample Type</label>
            <input type="text" name="sampletype" id="sampletype"
                <?php
                  echo 'value="'.htmlentities($ViewData["sampletype"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="Abstract Title">Abstract Title</label>
            <textarea name="abstract" id="abstract"><?php $abstract = htmlentities($ViewData["abstract"]); echo $abstract; ?>
            </textarea>
            </fieldset>

            <fieldset>
                 <label for="Project Description">Project Description</label>
                   <textarea name="description" id="description" rows="1" cols="1" tabindex="9"><?php echo stripcslashes($ViewData['description']); ?></textarea>
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
