(() => {
    const root = document.querySelector('[data-account-registrations]');
    if (!root) return;
    const registrations = [
        {id:1,name:'Sample Student',type:'Student',studentNumber:'[11-digit number]',email:'student@example.test',registered:'Today, 9:15 AM',date:'today',status:'PENDING',birthdate:'Provided in registration',gradeLevel:'Grade level pending review',schoolYear:'School year pending review'},
        {id:2,name:'Sample Guardian',type:'Guardian',studentNumber:'[claimed child number]',email:'guardian@example.test',contact:'Contact provided',registered:'Today, 8:40 AM',date:'today',status:'PENDING',child:'Sample Student',relationship:'Parent'},
        {id:3,name:'Active Student Sample',type:'Student',studentNumber:'[11-digit number]',email:'active@example.test',registered:'Last week',date:'week',status:'ACTIVE',birthdate:'Verified by staff',gradeLevel:'Grade 10',schoolYear:'2026-2027'},
        {id:4,name:'Rejected Guardian Sample',type:'Guardian',studentNumber:'[claimed child number]',email:'rejected@example.test',contact:'Contact provided',registered:'Last month',date:'month',status:'REJECTED',child:'Sample Student',relationship:'Claimed guardian',reason:'Relationship could not be verified.'},
        {id:5,name:'Deactivated Student Sample',type:'Student',studentNumber:'[11-digit number]',email:'deactivated@example.test',registered:'Last month',date:'month',status:'DEACTIVATED',birthdate:'Verified by staff',gradeLevel:'Grade 9',schoolYear:'2025-2026'},
    ];
    const find = selector => root.querySelector(selector);
    const tabs = [...root.querySelectorAll('[data-registration-tab]')];
    const filtersForm = find('[data-registration-filters]');
    let tab = 'PENDING';
    let selected = null;
    let filters = {};

    const statusBadge = status => {
        const badge = document.createElement('span');
        badge.className = 'gs-badge';
        badge.dataset.status = status;
        badge.textContent = status;
        return badge;
    };
    const cell = (row, value) => {
        const element = document.createElement('td');
        if (value instanceof Node) element.append(value); else element.textContent = value;
        row.append(element);
        return element;
    };
    const matches = item => {
        const effectiveStatus = filters.status || tab;
        if (effectiveStatus && item.status !== effectiveStatus) return false;
        if (filters.type && item.type !== filters.type) return false;
        if (filters.date && item.date !== filters.date) return false;
        if (filters.search && ![item.name,item.studentNumber,item.email].join(' ').toLowerCase().includes(filters.search.toLowerCase())) return false;
        return true;
    };
    const render = () => {
        tabs.forEach(button => {
            const active = button.dataset.registrationTab === tab;
            button.setAttribute('aria-selected', String(active));
            button.classList.toggle('gs-btn-primary', active);
        });
        const body = find('[data-registration-rows]');
        body.replaceChildren();
        const visible = registrations.filter(matches);
        visible.forEach(item => {
            const row = document.createElement('tr');
            cell(row,item.name);cell(row,item.type);cell(row,item.studentNumber);cell(row,item.registered);cell(row,statusBadge(item.status));
            const review = document.createElement('button');review.type='button';review.className='gs-btn';review.textContent='Review';review.setAttribute('aria-label',`Review ${item.name} registration`);review.addEventListener('click',()=>showReview(item));cell(row,review);body.append(row);
        });
        if (!visible.length) { const row=document.createElement('tr');const empty=cell(row,'No sample registrations match this view.');empty.colSpan=6;body.append(row); }
    };
    const detail = (list,label,value,badgeValue) => {
        const wrapper=document.createElement('div'),term=document.createElement('dt'),description=document.createElement('dd');term.textContent=label;if(badgeValue)description.append(statusBadge(badgeValue));else description.textContent=value;wrapper.append(term,description);list.append(wrapper);
    };
    const showReview = item => {
        selected=item;find('[data-registration-list]').hidden=true;const review=find('[data-registration-review]');review.hidden=false;
        const list=find('[data-registration-details]');list.replaceChildren();
        detail(list,'Account Type',item.type);detail(list,item.type==='Student'?'Student Number':'Guardian',item.type==='Student'?item.studentNumber:item.name);detail(list,'Name',item.name);if(item.type==='Student'){detail(list,'Date of Birth',item.birthdate);detail(list,'Grade Level',item.gradeLevel);detail(list,'School Year',item.schoolYear);}else{detail(list,'Email',item.email);detail(list,'Contact',item.contact);}detail(list,'Registered',item.registered);detail(list,'Status','',item.status);
        const claim=find('[data-guardian-claim]');claim.hidden=item.type!=='Guardian';find('[data-guardian-claim-copy]').textContent=item.type==='Guardian'?`Student Number: ${item.studentNumber} / Student: ${item.child} / Relationship: ${item.relationship}`:'';
        find('[data-activate-open]').hidden=item.status!=='PENDING';find('[data-reject-open]').hidden=item.status!=='PENDING';find('[data-deactivate-open]').hidden=item.status!=='ACTIVE';find('[data-registration-feedback]').textContent=item.reason?`Previous decision reason: ${item.reason}`:'Reviewing sample data. No persisted status has changed.';review.focus();
    };
    const previewChange = (status, reason) => {
        if (!selected) return;
        selected.status=status;if(reason)selected.reason=reason;
        root.querySelectorAll('dialog[open]').forEach(dialog=>dialog.close());render();showReview(selected);find('[data-registration-feedback]').textContent=`${status} demonstrated on this page only. No account access changed.`;
    };
    tabs.forEach(button=>button.addEventListener('click',()=>{tab=button.dataset.registrationTab;filters.status='';filtersForm.elements.status.value='';render();}));
    filtersForm.addEventListener('submit',event=>{event.preventDefault();filters=Object.fromEntries(new FormData(filtersForm));render();});
    filtersForm.addEventListener('reset',()=>{filters={};setTimeout(render);});
    filtersForm.elements.search.addEventListener('input',()=>{filters.search=filtersForm.elements.search.value.trim();render();});
    find('[data-back-registrations]').addEventListener('click',()=>{find('[data-registration-review]').hidden=true;find('[data-registration-list]').hidden=false;render();tabs.find(button=>button.dataset.registrationTab===tab)?.focus();});
    find('[data-activate-open]').addEventListener('click',()=>{find('[data-activate-summary]').textContent=`${selected.name} / ${selected.type}`;find('[data-activation-warning]').textContent=selected.type==='Guardian'?'Activating this Guardian account may allow access to authorized linked student information. Confirm the relationship before activation.':'Activation will allow this user to sign in to the Student Portal when server enforcement is implemented.';find('[data-activate-dialog]').showModal();});
    find('[data-reject-open]').addEventListener('click',()=>{find('[data-reject-form]').reset();find('[data-reject-dialog]').showModal();});
    find('[data-deactivate-open]').addEventListener('click',()=>{find('[data-deactivate-summary]').textContent=`Deactivate ${selected.name}'s ${selected.type} portal account?`;find('[data-deactivate-dialog]').showModal();});
    root.querySelectorAll('[data-registration-cancel]').forEach(button=>button.addEventListener('click',()=>button.closest('dialog').close()));
    find('[data-activate-confirm]').addEventListener('click',()=>previewChange('ACTIVE'));
    find('[data-deactivate-confirm]').addEventListener('click',()=>previewChange('DEACTIVATED'));
    find('[data-reject-form]').addEventListener('submit',event=>{event.preventDefault();const reason=event.currentTarget.elements.reason;if(!reason.reportValidity())return;previewChange('REJECTED',reason.value.trim());});
    render();
})();
