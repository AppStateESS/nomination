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

<div class="row">
    <div class="col-md-10">

        <h1>{AWARD_TITLE} Nomination</h1>

        <p>This nomination period will end on <strong>{PERIOD_END}</strong>.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3>Nominee Information</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <!-- BEGIN NOMINEE_BANNER_ID -->
        <div class="form-group">
            <label class="req">Banner ID</label>
            {NOMINEE_BANNER_ID}
        </div>
        <!-- END NOMINEE_BANNER_ID -->


        <div class="form-group">
            <label class="req">{NOMINEE_FIRST_NAME_LABEL}</label>
            {NOMINEE_FIRST_NAME}
        </div>

        <div class="form-group">
            <label>{NOMINEE_MIDDLE_NAME_LABEL}</label>
            {NOMINEE_MIDDLE_NAME}
        </div>

        <div class="form-group">
            <label class="req">{NOMINEE_LAST_NAME_LABEL}</label>
            {NOMINEE_LAST_NAME}
        </div>

        <div class="form-group">
            <label class="req">
                ASU Email
            </label>
            <div class="input-group">
                {NOMINEE_EMAIL}
                {NOMINEE_ADD_ON}
            </div>
        </div>

        <!-- BEGIN NOMINEE_ASUBOX -->
        <div class="form-group">
            <label class="req">{NOMINEE_ASUBOX_LABEL}</label>
            {NOMINEE_ASUBOX}
        </div>
        <!-- END NOMINEE_ASUBOX -->

        <!-- BEGIN NOMINEE_PHONE -->
        <div class="form-group">
            <label class="req">{NOMINEE_PHONE_LABEL}</label>
            {NOMINEE_PHONE}
        </div>
        <!-- END NOMINEE_PHONE -->

        <!-- BEGIN NOMINEE_POSITION -->
        <div class="form-group">
            <label>{NOMINEE_POSITION_LABEL}</label>
            {NOMINEE_POSITION}
        </div>
        <!-- END NOMINEE_POSITION -->

        <!-- BEGIN NOMINEE_DEPARTMENT_MAJOR -->
        <div class="form-group">
            <label>{NOMINEE_DEPARTMENT_MAJOR_LABEL}</label>
            {NOMINEE_DEPARTMENT_MAJOR}
        </div>
        <!-- END NOMINEE_DEPARTMENT_MAJOR -->

        <!-- BEGIN NOMINEE_GPA -->
        <div class="form-gruop">
            <label class="req">{NOMINEE_GPA_LABEL}</label>
            {NOMINEE_GPA}
        </div>
        <!-- END NOMINEE_GPA -->

        <!-- BEGIN NOMINEE_CLASS -->
        <div class="form-group">
            <label class="req">{NOMINEE_CLASS_LABEL}</label>
            {NOMINEE_CLASS}
        </div>
        <!-- END NOMINEE_CLASS -->

        <!-- BEGIN NOMINEE_YEARS -->
        <div class="form-group">
            <label>{NOMINEE_YEARS_LABEL}</label>
            {NOMINEE_YEARS}
        </div>
        <!-- END NOMINEE_YEARS -->
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <!-- BEGIN NOMINEE_RESPONSIBILITY -->
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
        <!-- END NOMINEE_RESPONSIBILITY -->
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Category</h3>
        <!-- BEGIN CATEGORY -->
            <p>
                Please choose the appropriate category:
            </p>
            <div class="radio">
                <label>
                    {CATEGORY_1} <strong>Student Leader</strong> One who has provided distinguished leadership above that of other student leaders.
                </label>
            </div>
            <div class="radio">
                <label>
                    {CATEGORY_2} <strong>Student Development Educator within the Division of Student Development</strong> For meritorious leadership in his or her work to enrich the quality of student life and learning.
                </label>
            </div>
            <div class="radio">
                <label>
                    {CATEGORY_3} <strong>Faculty Member</strong> One who has provided meritorious leadership through his or her work with student clubs or organizations, or work that enriches the quality of student life and learning outside of the classroom.
                </label>
            </div>
            <div class="radio">
                <label>
                    {CATEGORY_4} <strong>Employee of Appalachian State University</strong> One who has shown that he or she has provided meritorious leadership which has significantly enriched the quality of student life and learning.
                </label>
            </div>
        <!-- END CATEGORY -->
    </div>
</div>

<!-- BEGIN REFERENCES_OVERALL -->

<div class="row">
    <div class="col-md-12">
        <h3>References</h3>
        <p>
            <strong>Contact information for {NUM_REFS} reference(s) must be included for this
            application.</strong> These references will be sent a link to submit letters of
            recommendation which should include relevant information that gives examples
            of your leadership ability, dependability, integrity, self-confidence, maturity,
            and communication skills as it relates to your abilities to serve on one of
            the student boards.
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <!-- Reference 0 -->
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- BEGIN REFERENCE_FIRST_NAME_0 -->
                <h4>Reference</h4>
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
        </div>


        <!-- Refrence 1 -->
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- BEGIN REFERENCE_FIRST_NAME_1 -->
                <h4>Reference</h4>
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
        </div>


        <!-- Reference 2 -->
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- BEGIN REFERENCE_FIRST_NAME_2 -->
                <h4>Reference</h4>
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
    </div>
</div>
<!-- END REFERENCES_OVERALL -->

<!-- BEGIN STATEMENT -->
<div class="row">
    <div class="col-md-12">
        <h3>Statement</h3>
        <p>
            Please upload a statement which supports this nomination for {AWARD_TITLE}. This statement should address the following aspects for the person you are nominating:
                <ul>
                    <li>Work and involvement with students outside the classroom</li>
                    <li>Role or roles that have had an impact on the life of students on campus</li>
                    <li>Meritorious involvement- why does this person stand above others?</li>
                </ul>
        </p>
        <p>
            {STATEMENT}
        </p>
        <!-- END STATEMENT -->
    </div>
</div>

<!-- BEGIN NOMINATOR_OVERALL -->
<div class="row">
    <div class="col-md-6">
        <h2>Nominator Information</h2>
    </div>
</div>


<div class="row">
    <div class="col-md-4">
        <!-- BEGIN NOMINATOR_FIRST_NAME -->
        <div class="form-group">
            <label class="req">{NOMINATOR_FIRST_NAME_LABEL}</label>
            {NOMINATOR_FIRST_NAME}
        </div>
        <!-- END NOMINATOR_FIRST_NAME -->

        <!-- BEGIN NOMINATOR_MIDDLE_NAME -->
        <div class="form-group">
            <label class="req">{NOMINATOR_MIDDLE_NAME_LABEL}</label>
            {NOMINATOR_MIDDLE_NAME}
        </div>
        <!-- END NOMINATOR_MIDDLE_NAME -->

        <!-- BEGIN NOMINATOR_LAST_NAME -->
        <div class="form-group">
            <label class="req">{NOMINATOR_LAST_NAME_LABEL}</label>
            {NOMINATOR_LAST_NAME}
        </div>
        <!-- END NOMINATOR_LAST_NAME -->

        <!-- BEGIN NOMINATOR_ADDRESS -->
        <div class="form-group">
            <label class="req">{NOMINATOR_ADDRESS_LABEL}</label>
            {NOMINATOR_ADDRESS}
        </div>
        <!-- END NOMINATOR_ADDRESS -->

        <!-- BEGIN NOMINATOR_PHONE -->
        <div class="form-group">
            <label class="req">{NOMINATOR_PHONE_LABEL}</label>
            {NOMINATOR_PHONE}
        </div>
        <!-- END NOMINATOR_PHONE -->

        <!-- BEGIN NOMINATOR_EMAIL -->
        <div class="form-group">
            <label class="req">ASU E-Mail</label>
            <div class="input-group">
                {NOMINATOR_EMAIL}
                {NOMINATOR_ADD_ON}
            </div>
        </div>
        <!-- END NOMINATOR_EMAIL -->

        <!-- BEGIN NOMINATOR_RELATIONSHIP -->
        <div class="form-group">
            <label>{NOMINATOR_RELATIONSHIP_LABEL}</label>
            {NOMINATOR_RELATIONSHIP}
        </div>
        <!-- END NOMINATOR_RELATIONSHIP -->
    </div>
</div>
<!-- END NOMINATOR_OVERALL -->

<div class="row">
    <div class="col-md-8">

        {CAPTCHA_IMAGE}

        <button type="submit" class="btn btn-lg btn-success">Submit Changes</button>

    </div>
</div>

{END_FORM}
