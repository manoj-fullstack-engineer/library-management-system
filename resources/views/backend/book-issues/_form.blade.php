<ul class="nav nav-tabs mb-4" id="issueReturnTabs" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" id="issue-tab" data-bs-toggle="tab" data-bs-target="#tab-issue" type="button">📘 Issue</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="return-tab" data-bs-toggle="tab" data-bs-target="#tab-return" type="button">🔄 Return</button>
    </li>
</ul>

<div class="tab-content">
    @include('backend.book-issues._tab_issue')
    @include('backend.book-issues._tab_return')
</div>
<div style="background: red; height: 10px;"></div>
