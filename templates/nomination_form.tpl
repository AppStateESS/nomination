<div class="col-md-12">
    <!-- BEGIN cancel -->
    <div class="row">
      <h3>Request Nomination Withdrawal</h3>
      {START_FORM}
      <button type="submit" class="btn btn-lg btn-danger">Request Cancellation</button>
      {END_FORM}
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
<div class="row">
  <div class="col-md-12">

{START_FORM}

<h2>{AWARD_TITLE}</h2>

<p>This nomination period will end on <strong>{PERIOD_END}</strong>.</p>


<h3>Nominee Information</h3>

<div class="col-md-12">
  <!-- BEGIN NOMINEE_BANNER_ID -->
  <div class="row">
    <label class="req">
      Banner ID
    </label>
  </div>
  <div class="row">
    <div class="col-md-6">
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
    <div class="col-md-6">
      {NOMINEE_FIRST_NAME}
    </div>
  </div>

  <div class="row">
    <label>
      {NOMINEE_MIDDLE_NAME_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-6">
      {NOMINEE_MIDDLE_NAME}
    </div>
  </div>

  <div class="row">
    <label class="req">
      {NOMINEE_LAST_NAME_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-6">
      {NOMINEE_LAST_NAME}
    </div>
  </div>

  <div class="row">
    <label class="req">
      ASU Email
    </label>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <div class="input-group">
          {NOMINEE_EMAIL}
          {NOMINEE_ADD_ON}
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
    <div class="col-md-6">
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
    <div class="col-md-6">
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
    <div class="col-md-6">
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
    <div class="col-md-6">
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
    <div class="col-md-6">
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
    <div class="col-md-6">
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
    <div class="col-md-6">
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



  <div>
    <!-- BEGIN REFERENCE_FIRST_NAME_0 -->
    <div class="row">
      <h4>
        Reference
      </h4>
    </div>
    <div class="row">
      <label class="req">
        First Name
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_FIRST_NAME_0}
      </div>
    </div>
    <!-- END REFERENCE_FIRST_NAME_0 -->

    <!-- BEGIN REFERENCE_LAST_NAME_0 -->
    <div class="row">
      <label class="req">
        Last Name
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_LAST_NAME_0}
      </div>
    </div>
    <!-- END REFERENCE_LAST_NAME_0 -->

    <!-- BEGIN REFERENCE_DEPARTMENT_0 -->
    <div class="row">
      <label>
        Department
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_DEPARTMENT_0}
      </div>
    </div>
    <!-- END REFERENCE_DEPARTMENT_0 -->

    <!-- BEGIN REFERENCE_PHONE_0 -->
    <div class="row">
      <label class="req">
        Phone Number
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_PHONE_0}
      </div>
    </div>
    <!-- END REFERENCE_PHONE_0 -->

    <!-- BEGIN REFERENCE_EMAIL_0 -->
    <div class="row">
      <label class="req">
        Email Address
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_EMAIL_0}
      </div>
    </div>
    <!-- END REFERENCE_EMAIL_0 -->

    <!-- BEGIN REFERENCE_RELATIONSHIP_0 -->
    <div class="row">
      <label>
        Relationship to Nominee
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_RELATIONSHIP_0}
      </div>
    </div>
    <!-- END REFERENCE_RELATIONSHIP_0 -->
  </div>

  <div>
    <!-- BEGIN REFERENCE_FIRST_NAME_1 -->
    <div class="row">
      <h4>
        Reference
      </h4>
    </div>
    <div class="row">
      <label class="req">
        First Name
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_FIRST_NAME_1}
      </div>
    </div>
    <!-- END REFERENCE_FIRST_NAME_1 -->

    <!-- BEGIN REFERENCE_LAST_NAME_1 -->
    <div class="row">
      <label class="req">
        Last Name
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_LAST_NAME_1}
      </div>
    </div>
    <!-- END REFERENCE_LAST_NAME_1 -->

    <!-- BEGIN REFERENCE_DEPARTMENT_1 -->
    <div class="row">
      <label>
        Department
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_DEPARTMENT_1}
      </div>
    </div>
    <!-- END REFERENCE_DEPARTMENT_1 -->

    <!-- BEGIN REFERENCE_PHONE_1 -->
    <div class="row">
      <label class="req">
        Phone Number
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_PHONE_1}
      </div>
    </div>
    <!-- END REFERENCE_PHONE_1 -->

    <!-- BEGIN REFERENCE_EMAIL_1 -->
    <div class="row">
      <label class="req">
        Email Address
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_EMAIL_1}
      </div>
    </div>
    <!-- END REFERENCE_EMAIL_1 -->

    <!-- BEGIN REFERENCE_RELATIONSHIP_1 -->
    <div class="row">
      <label>
        Relationship to Nominee
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_RELATIONSHIP_1}
      </div>
    </div>
    <!-- END REFERENCE_RELATIONSHIP_1 -->
  </div>

  <div>
    <!-- BEGIN REFERENCE_FIRST_NAME_2 -->
    <div class="row">
      <h4>
        Reference
      </h4>
    </div>
    <div class="row">
      <label class="req">
        First Name
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_FIRST_NAME_2}
      </div>
    </div>
    <!-- END REFERENCE_FIRST_NAME_2 -->
    <!-- BEGIN REFERENCE_LAST_NAME_2 -->
    <div class="row">
      <label class="req">
        Last Name
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_LAST_NAME_2}
      </div>
    </div>
    <!-- END REFERENCE_LAST_NAME_2 -->

    <!-- BEGIN REFERENCE_DEPARTMENT_2 -->
    <div class="row">
      <label>
        Department
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_DEPARTMENT_2}
      </div>
    </div>
    <!-- END REFERENCE_DEPARTMENT_2 -->

    <!-- BEGIN REFERENCE_PHONE_2 -->
    <div class="row">
      <label class="req">
        Phone Number
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_PHONE_2}
      </div>
    </div>
    <!-- END REFERENCE_PHONE_2 -->

    <!-- BEGIN REFERENCE_EMAIL_2 -->
    <div class="row">
      <label class="req">
        Email Address
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_EMAIL_2}
      </div>
    </div>
    <!-- END REFERENCE_EMAIL_2 -->

    <!-- BEGIN REFERENCE_RELATIONSHIP_2 -->
    <div class="row">
      <label>
        Relationship to Nominee
      </label>
    </div>
    <div class="row">
      <div class="col-md-6">
        {REFERENCE_RELATIONSHIP_2}
      </div>
    </div>
    <!-- END REFERENCE_RELATIONSHIP_2 -->
  </div>

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
      <div class="col-md-6">
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
      <div class="col-md-6">
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
      <div class="col-md-6">
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
      <div class="col-md-6">
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
      <div class="col-md-6">
        {NOMINATOR_PHONE}
      </div>
    </div>
    <!-- END NOMINATOR_PHONE -->

    <!-- BEGIN NOMINATOR_EMAIL -->
    <div class="row">
      <label class="req">
        ASU E-Mail
      </label>
    </div>
    <div class="row">
      <div class="form-group">
        <div class="col-md-6">
          <div class="input-group">
            {NOMINATOR_EMAIL}
            {NOMINATOR_ADD_ON}
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
      <div class="col-md-6">
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
      <button type="submit" class="btn btn-lg btn-success">Submit Changes</button>
    </div>

    {END_FORM}
  </div>
</div>
</div>
