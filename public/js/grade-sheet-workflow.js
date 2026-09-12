(() => {
    const canEdit = (state, period) => state === 'RETURNED' || (state === 'DRAFT' && period === 'OPEN');
    if (typeof module !== 'undefined') module.exports={canEdit};
    if (typeof document === 'undefined') return;
    const controls=document.querySelector('[data-sheet-controls]');if(!controls)return;
    const root=controls.closest('.gs-portal'), find=s=>root.querySelector(s);
    const state=find('[data-sheet-state]'),period=find('[data-sheet-period]');
    const inputs=[...root.querySelectorAll('.gs-manual-table .gs-grade-input')];
    const originalDisabled=inputs.map(input=>input.disabled);
    const missing=()=>inputs.filter(input=>input.value.trim()==='').length;
    const updateMissing=()=>{inputs.forEach(input=>{const note=input.closest('td').querySelector('[data-grade-missing]');note.hidden=input.value.trim()!=='';});find('[data-missing-count]').textContent=`${missing()} not encoded`;};
    const render=()=>{
        const editable=canEdit(state.value,period.value);
        inputs.forEach((input,i)=>{input.disabled=originalDisabled[i] || (period.value==='UPCOMING' && state.value!=='RETURNED');input.readOnly=!editable;});
        find('[data-sheet-badge]').textContent=state.value;find('[data-sheet-badge]').dataset.status=state.value;
        find('[data-sheet-message]').textContent={DRAFT:'Draft: continue encoding final grades.',SUBMITTED:'This grade sheet has been submitted for review. Waiting for approval.',RETURNED:'This grade sheet was returned for correction.',APPROVED:'This grade sheet has been approved.'}[state.value];
        find('[data-period-message]').textContent={OPEN:'OPEN / Sample period: Sep 15, 2026 at 8:00 AM to Sep 20, 2026 at 11:59 PM.',UPCOMING:'UPCOMING / Sample opening: Dec 10, 2026 at 8:00 AM.',CLOSED:'CLOSED / Sample deadline: Sep 20, 2026 at 11:59 PM. Grade sheet is read-only unless returned for correction.'}[period.value];
        find('[data-return-info]').hidden=state.value!=='RETURNED';find('[data-approval-info]').hidden=state.value!=='APPROVED';
        root.querySelectorAll('[data-draft-action],[data-submit-sheet]').forEach(button=>{button.hidden=['SUBMITTED','APPROVED'].includes(state.value);button.disabled=!editable || inputs.length===0 || originalDisabled.every(Boolean);});
        find('[data-legacy-save]')?.setAttribute('hidden','');
        updateMissing();
    };
    inputs.forEach(input=>input.addEventListener('input',updateMissing));
    state.addEventListener('change',render);period.addEventListener('change',render);
    find('[data-draft-action]').addEventListener('click',()=>{if(!inputs.every(input=>input.reportValidity()))return;find('[data-workflow-feedback]').textContent='Draft retained on this page only. Nothing was saved to the database.';});
    find('[data-submit-sheet]').addEventListener('click',()=>{
        if(!inputs.every(input=>input.reportValidity()))return;
        find('[data-submit-missing]').textContent=missing()?`${missing()} students are missing grades. Complete all grades before submitting.`:'All students have a final grade.';
        find('[data-confirm-sheet]').disabled=missing()>0 || inputs.length===0;
        find('#submit-sheet-dialog').showModal();
    });
    find('[data-confirm-sheet]').addEventListener('click',()=>{if(missing() || !canEdit(state.value,period.value))return;state.value='SUBMITTED';find('#submit-sheet-dialog').close();render();find('[data-workflow-feedback]').textContent='Submission demonstrated. No grade sheet was sent to staff.';});
    find('[data-edit-returned]').addEventListener('click',()=>inputs.find(input=>!input.disabled && !input.closest('tr').hidden)?.focus());
    render();
})();
