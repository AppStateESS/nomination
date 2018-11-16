<div class="row">
  <div class="col-md-12">
    <!-- BEGIN cancel -->
    <div class="row">
      <div class="col-md-6">
        <h3>Request Nomination Withdrawal</h3>
        {START_FORM}
        <button type="submit" class="btn btn-lg btn-danger">Request Cancellation</button>
        {END_FORM}
      </div>
    </div>
    <!-- END cancel -->
    <!-- BEGIN withdraw -->
    <div class="row">
      <h3>Cancel Nomination Withdrawal</h3>
      {START_FORM}
      <button type="submit" class="btn btn-lg btn-danger">Withdraw Request</button>
      {END_FORM}
    </div>
    <!-- END withdraw -->
  </div>
</div>
{START_FORM}
<h3>{AWARD_TITLE} Nomination</h3>
<p>{AWARD_DESCRIPTION}</p>
<p>This nomination period will end on
  <strong>{PERIOD_END}</strong>.</p>
<hr/>
<h4>Nominee Information</h3>
<div class="row">
  <!-- BEGIN NOMINEE_BANNER_ID -->
  <div class="form-group col-md-4">
    <label class="req">Banner ID</label>
    {NOMINEE_BANNER_ID}
  </div>
  <!-- END NOMINEE_BANNER_ID -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINEE_FIRST_NAME_LABEL}</label>
    {NOMINEE_FIRST_NAME}
  </div>
  <!-- BEGIN NOMINEE_MIDDLE_NAME -->
  <div class="form-group col-md-4">
    <label>{NOMINEE_MIDDLE_NAME_LABEL}</label>
    {NOMINEE_MIDDLE_NAME}
  </div>
  <!-- END NOMINEE_MIDDLE_NAME -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINEE_LAST_NAME_LABEL}</label>
    {NOMINEE_LAST_NAME}
  </div>
  <div class="form-group col-md-4">
    <label class="req">
      ASU Email
    </label>
    <div class="input-group">
      {NOMINEE_EMAIL}
      <!--{NOMINEE_ADD_ON}-->
    </div>
  </div>
  <!-- BEGIN NOMINEE_ASUBOX -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINEE_ASUBOX_LABEL}</label>
    {NOMINEE_ASUBOX}
  </div>
  <!-- END NOMINEE_ASUBOX -->
  <!-- BEGIN NOMINEE_PHONE -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINEE_PHONE_LABEL}</label>
    {NOMINEE_PHONE}
  </div>
  <!-- END NOMINEE_PHONE -->
  <!-- BEGIN NOMINEE_POSITION -->
  <div class="form-group col-md-4">
    <label>{NOMINEE_POSITION_LABEL}</label>
    {NOMINEE_POSITION}
  </div>
  <!-- END NOMINEE_POSITION -->
  <!-- BEGIN NOMINEE_DEPARTMENT_MAJOR -->
  <div class="form-group col-md-4">
    <label>{NOMINEE_DEPARTMENT_MAJOR_LABEL}</label>
    {NOMINEE_DEPARTMENT_MAJOR}
  </div>
  <!-- END NOMINEE_DEPARTMENT_MAJOR -->
  <!-- BEGIN NOMINEE_GPA -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINEE_GPA_LABEL}</label>
    {NOMINEE_GPA}
  </div>
  <!-- END NOMINEE_GPA -->
  <!-- BEGIN NOMINEE_CLASS -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINEE_CLASS_LABEL}</label>
    {NOMINEE_CLASS}
  </div>
  <!-- END NOMINEE_CLASS -->
  <!-- BEGIN NOMINEE_YEARS -->
  <div class="form-group col-md-4">
    <label>{NOMINEE_YEARS_LABEL}</label>
    {NOMINEE_YEARS}
  </div>
  <!-- END NOMINEE_YEARS -->
</div>
<div class="row">
  <div class="col-md-6">
    <!-- BEGIN NOMINEE_RESPONSIBILITY -->
    <p>
      Have you ever been found responsible or accepted responsibility for violating ASU's (or another
      school's) policies, or any law or regulation?
    </p>
    <div class="radio">
      <label>
        {NOMINEE_RESPONSIBILITY_1} {NOMINEE_RESPONSIBILITY_1_LABEL}
      </label>
    </div>
    <div class="radio">
      <label>
        {NOMINEE_RESPONSIBILITY_2} {NOMINEE_RESPONSIBILITY_2_LABEL}
      </label>
    </div>
    <!-- END NOMINEE_RESPONSIBILITY -->
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <h4>Category</h4>
    <!-- BEGIN CATEGORY -->
    <p>
      Please choose the appropriate category:
    </p>
    <div class="radio">
      <label>
        {CATEGORY_1}
        <strong>Student Leader</strong>
        One who has provided distinguished leadership above that of other student leaders.
      </label>
    </div>
    <div class="radio">
      <label>
        {CATEGORY_2}
        <strong>Student Affairs Educator within the Division of Student Affairs</strong>
        For meritorious leadership in his or her work to enrich the quality of student life and learning.
      </label>
    </div>
    <div class="radio">
      <label>
        {CATEGORY_3}
        <strong>Faculty Member</strong>
        One who has provided meritorious leadership through his or her work with student clubs or
        organizations, or work that enriches the quality of student life and learning outside of the
        classroom.
      </label>
    </div>
    <div class="radio">
      <label>
        {CATEGORY_4}
        <strong>Employee of Appalachian State University</strong>
        One who has shown that he or she has provided meritorious leadership which has significantly
        enriched the quality of student life and learning.
      </label>
    </div>
    <!-- END CATEGORY -->
  </div>
</div>
<!-- BEGIN REFERENCES_OVERALL -->
<h4>References</h4>
<p>
  <strong>Contact information for {NUM_REFS} reference(s) must be included for this application.</strong>
  These references will be sent a link to submit letters of recommendation which should include
  relevant information that gives examples of the nominees leadership ability, dependability,
  integrity, self-confidence, maturity, and communication sklls ​that reflect the nominee's ability to
  enrich the quality of student life and learning outside of the classroom.
</p>
<div class="row">
  <!-- Reference 0 -->
  <div class="col-md-6">
    <!-- BEGIN REFERENCE_FIRST_NAME_0 -->
    <h4>Reference 1</h4>
    <div class="form-group">
      <label class="req">First Name</label>
      {REFERENCE_FIRST_NAME_0}
    </div>
    <!-- END REFERENCE_FIRST_NAME_0 -->
    <!-- BEGIN REFERENCE_LAST_NAME_0 -->
    <div class="form-group">
      <label class="req">Last Name</label>
      {REFERENCE_LAST_NAME_0}
    </div>
    <!-- END REFERENCE_LAST_NAME_0 -->
    <!-- BEGIN REFERENCE_DEPARTMENT_0 -->
    <div class="form-group">
      <label>Department</label>
      {REFERENCE_DEPARTMENT_0}
    </div>
    <!-- END REFERENCE_DEPARTMENT_0 -->
    <!-- BEGIN REFERENCE_PHONE_0 -->
    <div class="form-group">
      <label class="req">Phone Number</label>
      {REFERENCE_PHONE_0}
    </div>
    <!-- END REFERENCE_PHONE_0 -->
    <!-- BEGIN REFERENCE_EMAIL_0 -->
    <div class="form-group">
      <label class="req">Email Address</label>
      {REFERENCE_EMAIL_0}
    </div>
    <!-- END REFERENCE_EMAIL_0 -->
    <!-- BEGIN REFERENCE_RELATIONSHIP_0 -->
    <div class="form-group">
      <label>Relationship to Nominee</label>
      {REFERENCE_RELATIONSHIP_0}
    </div>
    <!-- END REFERENCE_RELATIONSHIP_0 -->
  </div>
  <!-- Reference 1 -->
  <div class="col-md-6">
    <!-- BEGIN REFERENCE_FIRST_NAME_1 -->
    <h4>Reference 2</h4>
    <div class="form-group">
      <label class="req">First Name</label>
      {REFERENCE_FIRST_NAME_1}
    </div>
    <!-- END REFERENCE_FIRST_NAME_1 -->
    <!-- BEGIN REFERENCE_LAST_NAME_1 -->
    <div class="form-group">
      <label class="req">Last Name</label>
      {REFERENCE_LAST_NAME_1}
    </div>
    <!-- END REFERENCE_LAST_NAME_1 -->
    <!-- BEGIN REFERENCE_DEPARTMENT_1 -->
    <div class="form-group">
      <label>Department</label>
      {REFERENCE_DEPARTMENT_1}
    </div>
    <!-- END REFERENCE_DEPARTMENT_1 -->
    <!-- BEGIN REFERENCE_PHONE_1 -->
    <div class="form-group">
      <label class="req">Phone Number</label>
      {REFERENCE_PHONE_1}
    </div>
    <!-- END REFERENCE_PHONE_1 -->
    <!-- BEGIN REFERENCE_EMAIL_1 -->
    <div class="form-group">
      <label class="req">Email Address</label>
      {REFERENCE_EMAIL_1}
    </div>
    <!-- END REFERENCE_EMAIL_1 -->
    <!-- BEGIN REFERENCE_RELATIONSHIP_1 -->
    <div class="form-group">
      <label>Relationship to Nominee</label>
      {REFERENCE_RELATIONSHIP_1}
    </div>
    <!-- END REFERENCE_RELATIONSHIP_1 -->
  </div>
  <!-- Reference 2 -->
  <div class="col-md-6">
    <!-- BEGIN REFERENCE_FIRST_NAME_2 -->
    <h4>Reference 3</h4>
    <div class="form-group">
      <label class="req">First Name</label>
      {REFERENCE_FIRST_NAME_2}
    </div>
    <!-- END REFERENCE_FIRST_NAME_2 -->
    <!-- BEGIN REFERENCE_LAST_NAME_2 -->
    <div class="form-group">
      <label class="req">Last Name</label>
      {REFERENCE_LAST_NAME_2}
    </div>
    <!-- END REFERENCE_LAST_NAME_2 -->
    <!-- BEGIN REFERENCE_DEPARTMENT_2 -->
    <div class="form-group">
      <label>Department</label>
      {REFERENCE_DEPARTMENT_2}
    </div>
    <!-- END REFERENCE_DEPARTMENT_2 -->
    <!-- BEGIN REFERENCE_PHONE_2 -->
    <div class="form-group">
      <label class="req">Phone Number</label>
      {REFERENCE_PHONE_2}
    </div>
    <!-- END REFERENCE_PHONE_2 -->
    <!-- BEGIN REFERENCE_EMAIL_2 -->
    <div class="form-group">
      <label class="req">Email Address</label>
      {REFERENCE_EMAIL_2}
    </div>
    <!-- END REFERENCE_EMAIL_2 -->
    <!-- BEGIN REFERENCE_RELATIONSHIP_2 -->
    <div class="form-group">
      <label>Relationship to Nominee</label>
      {REFERENCE_RELATIONSHIP_2}
    </div>
    <!-- END REFERENCE_RELATIONSHIP_2 -->
  </div>
</div>
<!-- END REFERENCES_OVERALL -->
<!-- BEGIN STATEMENT -->
<h3>Statement</h3>
<p>
  Please upload a statement which supports this nomination for {AWARD_TITLE}. This statement should
  address the following aspects for the person you are nominating:
<ul>
  <li>Work and involvement with students outside the classroom</li>
  <li>Role or roles that have had an impact on the life of students on campus</li>
  <li>Meritorious involvement- why does this person stand above others?</li>
</ul>
</p>
<p>
  {STATEMENT}
</p>
<!-- BEGIN DOWNLOAD -->
<hr />
<p>
  If you need to reupload a new statement, please use the choose file button above and resubmit the
  form. Otherwise the link below will allow you to see the document you've already uploaded.
  <br>
  {DOWNLOAD}
</p>
<!-- END DOWNLOAD -->
<!-- END STATEMENT -->
<!-- BEGIN NOMINATOR_OVERALL -->
<div class="row">
  <div class="col-md-6">
    <h2>Nominator Information</h2>
  </div>
</div>
<div class="row">
  <!-- BEGIN NOMINATOR_FIRST_NAME -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINATOR_FIRST_NAME_LABEL}</label>
    {NOMINATOR_FIRST_NAME}
  </div>
  <!-- END NOMINATOR_FIRST_NAME -->
  <!-- BEGIN NOMINATOR_MIDDLE_NAME -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINATOR_MIDDLE_NAME_LABEL}</label>
    {NOMINATOR_MIDDLE_NAME}
  </div>
  <!-- END NOMINATOR_MIDDLE_NAME -->
  <!-- BEGIN NOMINATOR_LAST_NAME -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINATOR_LAST_NAME_LABEL}</label>
    {NOMINATOR_LAST_NAME}
  </div>
  <!-- END NOMINATOR_LAST_NAME -->
  <!-- BEGIN NOMINATOR_ADDRESS -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINATOR_ADDRESS_LABEL}</label>
    {NOMINATOR_ADDRESS}
  </div>
  <!-- END NOMINATOR_ADDRESS -->
  <!-- BEGIN NOMINATOR_PHONE -->
  <div class="form-group col-md-4">
    <label class="req">{NOMINATOR_PHONE_LABEL}</label>
    {NOMINATOR_PHONE}
  </div>
  <!-- END NOMINATOR_PHONE -->
  <!-- BEGIN NOMINATOR_EMAIL -->
  <div class="form-group col-md-4">
    <label class="req">ASU E-Mail</label>
    <div class="input-group">
      {NOMINATOR_EMAIL}
      <!--{NOMINATOR_ADD_ON}-->
    </div>
  </div>
  <!-- END NOMINATOR_EMAIL -->
  <!-- BEGIN NOMINATOR_RELATIONSHIP -->
  <div class="form-group col-md-4">
    <label>{NOMINATOR_RELATIONSHIP_LABEL}</label>
    {NOMINATOR_RELATIONSHIP}
  </div>
  <!-- END NOMINATOR_RELATIONSHIP -->
  <!-- BEGIN alternate -->
  {alternate_award}
  <!-- END alternate -->
</div>
<div class="form-group">
  <p>
    In the event the nominee is unsuccessful in the Plemmons process, you can use the below application to "opt in" to other award nomination processes. Each award is housed in the Division of Student Affairs. Your nominee must meet the minimum award qualifications (e.g., a student employee for the Dunnigan award, a current Graduate Student for the Blimling award, etc.). Please select all awards for which you wish the nominee to be considered. Be sure to click the "Details" link for award requirements before "opting in." 
  </p>
  <div>
    <label><input type="checkbox" name="alternate_award[]" value="brooks" {brooks}/> Ronny L. Brooks Award</label>
    <a href="https://studentaffairs.appstate.edu/outstandingleadership/" target="_blank">Details</a>
  </div>
  <div>
    <label><input type="checkbox" name="alternate_award[]" value="dunnigan" {dunnigan}/> Bobby L. Dunnigan Service Award</label>
    <a href="https://studentaffairs.appstate.edu/outstandingservice/" target="_blank">Details</a>
  </div>
  <div>
    <label><input type="checkbox" name="alternate_award[]" value="blimling" {blimling}/> Gregory S. Blimling Award for Outstanding Graduate Student in Student Affairs</label>
    <a href="https://studentaffairs.appstate.edu/outstandinggs/" target="_blank">Details</a>
  </div>
  <div>
    <label><input type="checkbox" name="alternate_award[]" value="dibernardi" {dibernardi}/> Berardino DiBernardi Student Award for Leadership and Legacy</label>
    <a href="https://studentaffairs.appstate.edu/leadershiplegacy/" target="_blank">Details</a>
  </div>
</div>
<!-- END NOMINATOR_OVERALL -->
<button type="submit" class="btn btn-lg btn-success">Submit Nomination</button>
{END_FORM}
