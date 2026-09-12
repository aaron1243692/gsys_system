(() => {
    const matches=(sheet,filters)=>Object.entries(filters).every(([key,value])=>!value || (key==='search' ? [sheet.className,sheet.subject,sheet.teacher].join(' ').toLowerCase().includes(value.toLowerCase()) : String(sheet[key])===value));
    if(typeof module!=='undefined')module.exports={matches};
    if(typeof document==='undefined')return;
    const root=document.querySelector('[data-approval-app]');if(!root)return;const find=s=>root.querySelector(s);
    const students=[{id:'DEMO-001',name:'Sample Student A',grade:88},{id:'DEMO-002',name:'Sample Student B',grade:91},{id:'DEMO-003',name:'Sample Student C',grade:85}];
    const sheets=[
        {id:1,teacher:'Sample Teacher A',className:'Grade 10 - Rizal',level:'Grade 10',subject:'Mathematics',year:'2026-2027',quarter:1,status:'SUBMITTED',submitted:'Sep 20, 2026, 10:35 PM'},
        {id:2,teacher:'Sample Teacher B',className:'Grade 9 - Bonifacio',level:'Grade 9',subject:'English',year:'2026-2027',quarter:2,status:'RETURNED',submitted:'Dec 14, 2026, 9:00 AM',reason:'Please verify the first student grade.',reviewed:'Dec 15, 2026, 9:32 AM'},
        {id:3,teacher:'Sample Teacher A',className:'Grade 10 - Rizal',level:'Grade 10',subject:'Science',year:'2027-2028',quarter:3,status:'APPROVED',submitted:'Mar 19, 2028, 2:00 PM',reviewed:'Mar 20, 2028, 2:15 PM'}
    ];let selected=null,filters={};
    const form=find('[data-approval-filters]');
    for(const key of ['year','quarter','level','className','teacher','status'])for(const value of [...new Set(sheets.map(sheet=>sheet[key]))].sort()){const option=document.createElement('option');option.value=value;option.textContent=key==='quarter'?'Quarter '+value:value;form.elements[key].append(option);}
    const cell=(row,text)=>{const td=document.createElement('td');td.textContent=text;row.append(td);return td;};
    const badge=(cell,status)=>{const span=document.createElement('span');span.className='gs-badge';span.dataset.status=status;span.textContent=status;cell.append(span);};
    const render=()=>{
        root.querySelectorAll('[data-count]').forEach(node=>node.textContent=sheets.filter(sheet=>sheet.status===node.dataset.count).length);
        const body=find('[data-approval-rows]');body.replaceChildren();
        const visible=sheets.filter(sheet=>matches(sheet,filters));
        for(const sheet of visible){const row=document.createElement('tr');[sheet.teacher,sheet.className,sheet.subject,'Q'+sheet.quarter,students.length,sheet.submitted].forEach(value=>cell(row,value));badge(cell(row,''),sheet.status);const button=document.createElement('button');button.type='button';button.className='gs-btn';button.textContent='Review';button.setAttribute('aria-label',`Review ${sheet.subject}, ${sheet.className}, Quarter ${sheet.quarter}`);button.addEventListener('click',()=>review(sheet));cell(row,'').append(button);body.append(row);}
        if(!visible.length){const row=document.createElement('tr');cell(row,'No matching grade sheets. Adjust your filters or reset the search.').colSpan=8;body.append(row);}
    };
    const review=sheet=>{
        selected=sheet;find('[data-approval-list]').hidden=true;const panel=find('[data-review-panel]');panel.hidden=false;
        const context=find('[data-review-context]');context.replaceChildren();
        for(const [label,value] of Object.entries({Teacher:sheet.teacher,Class:sheet.className,Subject:sheet.subject,Quarter:'Quarter '+sheet.quarter,'School Year':sheet.year,Submitted:sheet.submitted,Status:sheet.status})){const div=document.createElement('div'),dt=document.createElement('dt'),dd=document.createElement('dd');dt.textContent=label;if(label==='Status')badge(dd,value);else dd.textContent=value;div.append(dt,dd);context.append(div);}
        const body=find('[data-review-students]');body.replaceChildren();students.forEach((student,index)=>{const row=document.createElement('tr');[index+1,student.id,student.name,student.grade].forEach(value=>cell(row,value));body.append(row);});
        for(const key of ['return','approve'])find(`[data-${key}-open]`).hidden=sheet.status!=='SUBMITTED';
        const history=find('[data-review-history]');history.hidden=sheet.status==='SUBMITTED';history.textContent=sheet.status==='RETURNED'?`Returned by Sample Reviewer / ${sheet.reviewed}. Reason: ${sheet.reason}`:`Approved by Sample Reviewer / ${sheet.reviewed}.`;
        find('[data-review-feedback]').textContent='Read-only review of sample grades. Actions apply to the entire sheet.';panel.focus();
    };
    const summary=()=>`${selected.teacher} / ${selected.subject} / ${selected.className} / Quarter ${selected.quarter} / ${selected.year} / ${students.length} student grades`;
    form.addEventListener('submit',event=>{event.preventDefault();filters=Object.fromEntries(new FormData(form));render();});
    form.addEventListener('reset',()=>{filters={};render();});
    form.elements.search.addEventListener('input',()=>{filters.search=form.elements.search.value.trim();render();});
    find('[data-back-list]').addEventListener('click',()=>{find('[data-review-panel]').hidden=true;find('[data-approval-list]').hidden=false;render();find('[data-approval-filters] select').focus();});
    find('[data-approve-open]').addEventListener('click',()=>{find('[data-approve-summary]').textContent=summary();find('[data-approve-dialog]').showModal();});
    find('[data-return-open]').addEventListener('click',()=>{find('[data-return-summary]').textContent=summary();find('[data-return-form]').reset();find('[data-return-dialog]').showModal();});
    root.querySelectorAll('[data-cancel-approval]').forEach(button=>button.addEventListener('click',()=>button.closest('dialog').close()));
    const commit=(status,reason)=>{if(selected.status!=='SUBMITTED')return;selected.status=status;selected.reason=reason;selected.reviewed='Just now (preview)';root.querySelectorAll('dialog[open]').forEach(dialog=>dialog.close());render();review(selected);find('[data-review-feedback]').textContent=`${status==='APPROVED'?'Approval':'Return'} demonstrated. Nothing was saved or sent.`;};
    find('[data-confirm-approval]').addEventListener('click',()=>commit('APPROVED'));
    find('[data-return-form]').addEventListener('submit',event=>{event.preventDefault();const reason=event.currentTarget.elements.reason;reason.setCustomValidity(reason.value.trim()?'':'Enter a reason for return.');if(!reason.reportValidity())return;commit('RETURNED',reason.value.trim());});
    find('[data-return-form] textarea').addEventListener('input',event=>event.target.setCustomValidity(''));
    render();
})();
