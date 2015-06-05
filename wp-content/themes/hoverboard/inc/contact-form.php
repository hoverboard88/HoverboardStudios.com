<form class="capsule-crm-form" onsubmit="return split_names();" action="https://service.capsulecrm.com/service/newlead" method="post">
  <p id="alert__thank-you" class="alert__thank-you alert alert-success well">Thank you for contacting us! We'll be in touch.</p>
  <input type="hidden" name="FORM_ID" value="527b4032-3da6-4716-8ced-67426a4aea61">
  <input type="hidden" name="COMPLETE_URL" value="<?php echo get_site_url(); ?>/#alert__thank-you">

  <!-- <input type="hidden" name="DEVELOPER" value="TRUE"/> -->
  <input type="hidden" id="FIRST_NAME" name="FIRST_NAME">

  <label for="LAST_NAME">Name <span class="span--required">(required)</span></label>
  <input type="text" required id="LAST_NAME" name="LAST_NAME">

  <label for="EMAIL">Email <span class="span--required">(required)</span></label>
  <input type="text" required id="EMAIL" name="EMAIL">

  <label for="PHONE">Phone</label>
  <input type="tel" id="PHONE" name="PHONE">

  <label for="CF_Budget">Project Budget <span class="span--required">(required)</span></label>
  <select id="CF_Budget" required name="CUSTOMFIELD[Budget]">
    <option value="">Budget Amount</option>
    <option value="4000">0 - $4,000</option>
    <option value="8000">$4,000 - $8,000</option>
    <option value="15000">$8,000 - $15,000</option>
    <option value="30000">$15,000 - $30,000</option>
    <option value="60000">$30,000 - $60,000</option>
    <option value="60001">$60,000+</option>
  </select>

  <label for="NOTE">Tell us about your project:</label>
  <textarea id="NOTE" name="NOTE"></textarea>

  <button class="clear single-spaced btn--purple" type="submit">Get In Touch</button>

</form>

<script>
function split_names () {

  var
    wholeName = document.getElementById('LAST_NAME').value,
    nameArray = wholeName.split(' ');

  document.getElementById('FIRST_NAME').value = nameArray[0];

  //remove first name from array
  nameArray.splice(0, 1);
  //join back into string
  nameArray = nameArray.join(' ');

  //dump the rest into LAST_NAME
  document.getElementById('LAST_NAME').value = nameArray;

}
</script>
