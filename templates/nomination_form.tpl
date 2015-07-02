<div id="nomination-nomination-form">
  <div id="maintenance" >
    <!-- BEGIN cancel -->
    <div id="cancel" style="">
      <h3 style="text-align: left;">Nomination Withdrawal Request</h3>
      {START_FORM}
      {SUBMIT}
      {END_FORM}
    </div>
    <!-- END cancel -->
    <!-- BEGIN resend -->
    <div id="resend" style="">
      <h3 style="text-align: left;">Resend Notification Emails</h3>
      {START_FORM}
      {USERS_1_LABEL}
      {USERS_1}
      {USERS_2_LABEL}
      {USERS_2}<br />
      {USERS_3_LABEL}
      {USERS_3}
      {USERS_4_LABEL}
      {USERS_4}<br />
      {SUBMIT}
      {END_FORM}
    </div>
    <!-- END resend -->
  </div>


{START_FORM}

<h2>{AWARD_TITLE}</h2>

<p>This nomination period will end on <strong>{PERIOD_END}</strong>.</p>


<h3>Nominee Information</h3>

<div class="col-md-12">
  <!-- BEGIN NOMINEE_BANNER_ID -->
  <div class="row">
    <label class="req">
      {NOMINEE_BANNER_ID_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_BANNER_ID}
    </div>
  </div>
  <!-- END NOMINEE_BANNER_ID -->


  <div class="row">
    <label class="req">
      {NOMINEE_FIRST_NAME_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_FIRST_NAME}
    </div>
  </div>

  <div class="row">
    <label>
      {NOMINEE_MIDDLE_NAME_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_MIDDLE_NAME}
    </div>
  </div>

  <div class="row">
    <label class="req">
      {NOMINEE_LAST_NAME_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_LAST_NAME}
    </div>
  </div>

  <div class="row">
    <label class="req">
      {NOMINEE_EMAIL_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="form-group">
        <div class="input-group">
          {NOMINEE_EMAIL}
          <div class="input-group-addon">
            @appstate.edu
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- BEGIN NOMINEE_ASUBOX -->
  <div class="row">
    <label class="req">
      {NOMINEE_ASUBOX_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_ASUBOX}
    </div>
  </div>
  <!-- END NOMINEE_ASUBOX -->

  <!-- BEGIN NOMINEE_PHONE -->
  <div class="row">
    <label class="req">
      {NOMINEE_PHONE_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_PHONE}
    </div>
  </div>
  <!-- END NOMINEE_PHONE -->

  <!-- BEGIN NOMINEE_POSITION -->
  <div class="row">
    <label>
      {NOMINEE_POSITION_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_POSITION}
    </div>
  </div>
  <!-- END NOMINEE_POSITION -->

  <!-- BEGIN NOMINEE_DEPARTMENT_MAJOR -->
  <div class="row">
    <label>
      {NOMINEE_DEPARTMENT_MAJOR_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_DEPARTMENT_MAJOR}
    </div>
  <!-- END NOMINEE_DEPARTMENT_MAJOR -->
  </div>

  <!-- BEGIN NOMINEE_GPA -->
  <div class="row">
    <label class="req">
      {NOMINEE_GPA_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_GPA}
    </div>
  </div>
  <!-- END NOMINEE_GPA -->

  <!-- BEGIN NOMINEE_CLASS -->
  <div class="row">
    <label class="req">
      {NOMINEE_CLASS_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_CLASS}
    </div>
  </div>
  <!-- END NOMINEE_CLASS -->

  <!-- BEGIN NOMINEE_YEARS -->
  <div class="row">
    <label>
      {NOMINEE_YEARS_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-8">
      {NOMINEE_YEARS}
    </div>
  </div>
  <!-- END NOMINEE_YEARS -->

  <!-- BEGIN NOMINEE_RESPONSIBILITY -->
  <div class="row">
    <p>
      Have you ever been found responsible or accepted responsibility for violating ASU's (or another school's) policies, or any law or regulation?
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
  </div>
  <!-- END NOMINEE_RESPONSIBILITY -->

  <!-- BEGIN CATEGORY -->
  <div class="row">
    <p>
      Please choose group you would like to apply to:
    </p>
    <div class="radio">
      <label>
        {CATEGORY_1}
        Student Conduct Board
      </label>
    </div>
    <div class="radio">
      <label>
        {CATEGORY_2}
        Academic Integrity Board
      </label>
    </div>
    <div class="radio">
      <label>
        {CATEGORY_3}
        Both / Either (Student Conduct and/or Academic Integrity Board)
      </label>
    </div>
  </div>
  <!-- END CATEGORY -->

  <!-- BEGIN REFERENCES_OVERALL -->
  <div class="row">
    <h3>References</h3>
    <p>
      <b>Contact information for {NUM_REFS} reference(s) must be included for this
      application.</b> These references will be sent a link to submit letters of
      recommendation which should include relevant information that gives examples
      of your leadership ability, dependability, integrity, self-confidence, maturity,
      and communication skills as it relates to your abilities to serve on one of
      the student boards.
    </p>
  </div>


  <!-- BEGIN REFERENCES_REPEAT -->
  <div>
    <div class="row">
      <h4>
        Reference
      </h4>
    </div>
    <!-- BEGIN REFERENCE_FIRST_NAME -->
    <div class="row">
      <label class="req">
        {REFERENCE_FIRST_NAME__LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {REFERENCE_FIRST_NAME_}
      </div>
    </div>
    <!-- END REFERENCE_FIRST_NAME -->
    <!-- BEGIN REFERENCE_LAST_NAME -->
    <div class="row">
      <label class="req">
        {REFERENCE_LAST_NAME__LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {REFERENCE_LAST_NAME_}
      </div>
    </div>
    <!-- END REFERENCE_LAST_NAME -->
    <!-- BEGIN REFERENCE_DEPARTMENT -->
    <div class="row">
      <label>
        {REFERENCE_DEPARTMENT__LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {REFERENCE_DEPARTMENT_}
      </div>
    </div>
    <!-- END REFERENCE_DEPARTMENT -->
    <!-- BEGIN REFERENCE_PHONE -->
    <div class="row">
      <label class="req">
        {REFERENCE_PHONE__LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {REFERENCE_PHONE_}
      </div>
    </div>
    <!-- END REFERENCE_PHONE -->
    <!-- BEGIN REFERENCE_EMAIL -->
    <div class="row">
      <label class="req">
        {REFERENCE_EMAIL__LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {REFERENCE_EMAIL_}
      </div>
    </div>
    <!-- END REFERENCE_EMAIL -->
    <!-- BEGIN REFERENCE_RELATIONSHIP -->
    <div class="row">
      <label>
        {REFERENCE_RELATIONSHIP__LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {REFERENCE_RELATIONSHIP_}
      </div>
    </div>
    <!-- END REFERENCE_RELATIONSHIP -->
    </div>
    <!-- END REFERENCES_REPEAT -->

    <!-- END REFERENCES_OVERALL -->

    <!-- BEGIN STATEMENT -->
    <div class="row">
      <h3>
        Resume & Short Answer
      </h3>
      <p>
        Please <a href="{FILES_DIR}mod/nomination/files/StudentConductApplicationQuestions.doc">
        download this document</a> (please right-click and select "save link as...")
        and insert your answers to the short-answer questions directly into the
        document. Then, attach your resume as the last page of the document and
        upload the document using the button below. Please save your document as a
        PDF file, if possible.
      </p>
      <p>
        {STATEMENT}
      </p>
    </div>
    <!-- END STATEMENT -->

    <!-- BEGIN NOMINATOR_OVERALL -->
    <div class="row">
      <h2>
        Nominator Information
      </h2>
    </div>

    <!-- BEGIN NOMINATOR_FIRST_NAME -->
    <div class="row">
      <label class="req">
        {NOMINATOR_FIRST_NAME_LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {NOMINATOR_FIRST_NAME}
      </div>
    </div>
    <!-- END NOMINATOR_FIRST_NAME -->

    <!-- BEGIN NOMINATOR_MIDDLE_NAME -->
    <div class="row">
      <label class="req">
        {NOMINATOR_MIDDLE_NAME_LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {NOMINATOR_MIDDLE_NAME}
      </div>
    </div>
    <!-- END NOMINATOR_MIDDLE_NAME -->

    <!-- BEGIN NOMINATOR_LAST_NAME -->
    <div class="row">
      <label class="req">
        {NOMINATOR_LAST_NAME_LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {NOMINATOR_LAST_NAME}
      </div>
    </div>
    <!-- END NOMINATOR_LAST_NAME -->

    <!-- BEGIN NOMINATOR_ADDRESS -->
    <div class="row">
      <label class="req">
        {NOMINATOR_ADDRESS_LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {NOMINATOR_ADDRESS}
      </div>
    </div>
    <!-- END NOMINATOR_ADDRESS -->

    <!-- BEGIN NOMINATOR_PHONE -->
    <div class="row">
      <label class="req">
        {NOMINATOR_PHONE_LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {NOMINATOR_PHONE}
      </div>
    </div>
    <!-- END NOMINATOR_PHONE -->

    <!-- BEGIN NOMINATOR_EMAIL -->
    <div class="row">
      <label class="req">
        {NOMINATOR_EMAIL_LABEL}
      </label>
    </div>
    <div class="row">
      <div class="form-group">
        <div class="col-md-8">
          <div class="input-group">
            {NOMINATOR_EMAIL}
            <div class="input-group-addon">
              @appstate.edu
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END NOMINATOR_EMAIL -->

    <!-- BEGIN NOMINATOR_RELATIONSHIP -->
    <div class="row">
      <label>
        {NOMINATOR_RELATIONSHIP_LABEL}
      </label>
    </div>
    <div class="row">
      <div class="col-md-8">
        {NOMINATOR_RELATIONSHIP}
      </div>
    </div>
    <!-- END NOMINATOR_RELATIONSHIP -->

    <p></p>

    <!-- END NOMINATOR_OVERALL -->

    <div class="row">
      <p>
        In order for you to be considered for the Student Conduct Board and/or
        Academic Integrity Board, you must be a student in good academic standing
        (GPA of 2.5 or above) and good conduct standing (not currently on probation)
        within the Appalachian community. You must also attest that all of the
        information provided is accurate to the best of your knowledge. By submitting
        this form, it will give the Office of Student Conduct staff permission to
        check your records and grades.
      </p>
    </div>

    <div class="row">
      {CAPTCHA_IMAGE}
    </div>

    <div class="row">
      {SUBMIT}
    </div>

    {END_FORM}
  </div>
</div>
