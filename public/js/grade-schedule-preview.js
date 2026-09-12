(() => {
    const statusAt = (period, current) => current < period.open ? 'UPCOMING' : current <= period.close ? 'OPEN' : 'CLOSED';
    const validPeriod = (open, close) => /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/.test(open) && /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/.test(close) && close > open;
    if (typeof module !== 'undefined') module.exports = { statusAt, validPeriod };
    if (typeof document === 'undefined') return;
    document.querySelectorAll('[data-schedule-preview]').forEach(root => {
        const find = selector => root.querySelector(selector);
        const year = find('[data-schedule-year]');
        const quarter = find('[data-preview-quarter]');
        const mode = find('[data-preview-state]');
        const schedules = {};
        for (const start of [2026, 2027]) schedules[`${start}-${start + 1}`] = [
            {open:`${start}-09-15T08:00`, close:`${start}-09-20T23:59`},
            {open:`${start}-12-10T08:00`, close:`${start}-12-15T23:59`},
            {open:`${start + 1}-03-15T08:00`, close:`${start + 1}-03-20T23:59`}
        ];
        const mounted = performance.now();
        const serverTime = Number(root.dataset.serverNow);
        const clock = new Intl.DateTimeFormat('sv-SE', {timeZone:root.dataset.timezone, year:'numeric', month:'2-digit',day:'2-digit',hour:'2-digit',minute:'2-digit',second:'2-digit',hourCycle:'h23'});
        const current = () => clock.format(new Date(serverTime + performance.now() - mounted)).replace(' ', 'T');
        const format = value => new Intl.DateTimeFormat('en-US',{timeZone:'UTC',month:'short',day:'numeric',year:'numeric',hour:'numeric',minute:'2-digit'}).format(new Date(value + ':00Z'));
        const status = period => statusAt({...period, open:period.open+':00',close:period.close+':00'},current());
        const badge = (element, value) => { element.textContent = value; element.className = 'gs-badge ' + (value === 'OPEN' ? 'gs-status-open' : value === 'UPCOMING' ? 'gs-badge-amber' : 'gs-badge-muted'); };
        const render = () => {
            const periods = schedules[year.value];
            const rows = find('[data-schedule-rows]');
            if (rows) {
                rows.replaceChildren();
                periods.forEach((period, index) => {
                    const row = document.createElement('tr');
                    for (const value of ['Q'+(index+1),format(period.open),format(period.close)]) { const cell=document.createElement('td');cell.textContent=value;row.append(cell); }
                    const cell=document.createElement('td'), label=document.createElement('span');badge(label,status(period));cell.append(label);row.append(cell);
                    const action=document.createElement('td'), button=document.createElement('button');button.type='button';button.className='gs-btn';button.textContent='Edit';button.setAttribute('aria-label',`Edit Quarter ${index+1} schedule`);button.addEventListener('click',()=>edit(index));action.append(button);row.append(action);rows.append(row);
                });
            }
            const period = periods[Number(quarter.value)-1];
            const state = mode.value === 'auto' ? status(period) : mode.value;
            badge(find('[data-preview-badge]'),state);
            find('[data-preview-message]').textContent = state === 'OPEN' ? `Grade encoding is open until ${format(period.close)}.` : state === 'UPCOMING' ? `Grade encoding has not opened yet. Encoding starts ${format(period.open)}.` : `Grade encoding is closed. Encoding closed ${format(period.close)}.`;
            find('[data-preview-dates]').textContent = `${year.value} / Quarter ${quarter.value}: ${format(period.open)} - ${format(period.close)} (${root.dataset.timezone})`;
            root.querySelectorAll('[data-preview-grade]').forEach(input=>{input.disabled=state==='UPCOMING';input.readOnly=state==='CLOSED';});
            find('[data-preview-save]').disabled=state!=='OPEN';
        };
        const dialog=find('[data-schedule-editor]'), form=find('[data-schedule-form]');let editing=0;
        const edit=index=>{
            editing=index;const period=schedules[year.value][index];
            find('[data-schedule-title]').textContent=`Quarter ${index+1} Grade Encoding Period`;
            find('[data-edit-year]').textContent=`School Year ${year.value} / ${root.dataset.timezone}`;
            [form.elements.openDate.value,form.elements.openTime.value]=period.open.split('T');
            [form.elements.closeDate.value,form.elements.closeTime.value]=period.close.split('T');
            find('[data-schedule-error]').textContent='';dialog.showModal();
        };
        root.querySelectorAll('[data-schedule-cancel]').forEach(button=>button.addEventListener('click',()=>dialog.close()));
        form?.addEventListener('submit',event=>{
            event.preventDefault();const open=form.elements.openDate.value+'T'+form.elements.openTime.value, close=form.elements.closeDate.value+'T'+form.elements.closeTime.value;
            if(!validPeriod(open,close)){find('[data-schedule-error]').textContent='Closing date and time must be after opening date and time.';return;}
            schedules[year.value][editing]={open,close};dialog.close();render();find('[data-schedule-feedback]').textContent=`Quarter ${editing+1} schedule updated in this preview only. Reloading resets changes.`;
        });
        for(const control of [year,quarter,mode])control.addEventListener('change',()=>{find('[data-preview-feedback]').textContent='';render();});
        find('[data-preview-save]').addEventListener('click',()=>{find('[data-preview-feedback]').textContent='Preview only. No student grades were saved.';});
        render();
        let lastStates = schedules[year.value].map(status).join(',');
        setInterval(()=>{const states=schedules[year.value].map(status).join(',');if(states!==lastStates && !dialog?.open){lastStates=states;render();}},1000);
    });
})();
