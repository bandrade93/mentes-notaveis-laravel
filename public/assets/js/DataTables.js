const BT_PRINT = {
    extend: 'print', 
    text: '<i class="fa fa-print"></i>',
    titleAttr: 'Imprimir',
    'className': 'btn btn-outline-dark btn-circle btn-circle-sm btn-table',
    exportOptions: {
        columns: ''
    }
};

class DataTables {

    static get TYPES_BAR() { return ['percent', 'performance', 'progress' ]; }

    constructor(options, print = false) {
        this.columns = options.columns;
        this.table = null;
        this.btFilter = (options.btFilter !== undefined) ? options.btFilter : true;

        this.onProcessing = null;
        this.onLoaded = null;

        if (options.hasOwnProperty('profile_id')) {
            this.profileId = options.profile_id;
        }

        $(window).on('init.bs.breakpoint', this.onBreakpoint);
        $(window).on('new.bs.breakpoint', this.onBreakpoint);
        bsBreakpoints.init();

        options['iDisplayLength'] = (sessionStorage.getItem('length')) ?? 10;

        this.init(options, print);
    }

    get RE_DATETIME() {
        return /(\d{4})(-)(\d{2})(-)(\d{2})[T](\d{2})[:](\d{2})[:](\d{2})[+](\d{2})[:](\d{2})/;
    }

    init(options, print) {
        options['buttons'] = (print) ? [BT_PRINT] : [];

        if (options['columnsToPrint']) {
            options.buttons[0].exportOptions.columns = options.columnsToPrint;
        }

        options['columnDefs'] = [
            {
                targets: 0,
                data: 'id',
                render: (data, type, row, meta) => {
                    if (this.columns[meta.col].title === '#') {
                        return `
                            <div class="animated-checkbox checkbox-xs-2">
                                <label>
                                    <input name="id[]" type="checkbox" value="${data}">
                                    <span class="label-text"></span>
                                </label>
                            </div>
                        `;
                    }

                    return data;
                },
                class: 'align-middle'
            },
            {
                targets: [-1, -2],
                render: (data, type, row, meta) => {
                    if (meta.col == this.columns.length - 1) {
                        var a = options['actions'];
                        var actions = '';

                        if (a) {
                            actions += (a.hasOwnProperty('qrcode')) ? a.qrcode : '';
                            actions += (a.hasOwnProperty('pass')) ? a.pass : '';
                            actions += (a.hasOwnProperty('student')) ? a.student : '';
                            actions += (a.hasOwnProperty('indicate')) ? a.indicate : '';
                            actions += (a.hasOwnProperty('classrooms')) ? a.classrooms : '';
                            actions += (a.hasOwnProperty('preview')) ? a.preview : '';
                            
                            if (row.plan_url != '') {
                                actions += (a.hasOwnProperty('class_plan')) ? a.class_plan : '';
                            }

                            if (a.hasOwnProperty('show')) {
                                if ((a.show.indexOf('Ticket') != -1) && this.profileId == 5) {
                                    if (row.department == 2) {
                                        actions += a.show;
                                    }
                                } else {
                                    actions += a.show;
                                }
                            }

                            actions += (a.hasOwnProperty('edit')) ? a.edit : '';
                            actions += (a.hasOwnProperty('settings')) ? a.settings : '';
                            actions += (a.hasOwnProperty('migrate')) ? a.migrate : '';

                            actions += (a.hasOwnProperty('reopen') && row.status == 3)
                                ? a.reopen
                                : '';

                            actions += (a.hasOwnProperty('close') && row.status != 3)
                                ? a.close
                                : '';

                            actions += (a.hasOwnProperty('chart')) ? a.chart : '';
                            actions += (a.hasOwnProperty('delete')) ? a.delete : '';
                            
                            if (a.hasOwnProperty('indicate')) {
                                actions = actions.replace(/\@/g, row.activity.id);
                                actions = actions.replace(/\*/g, row.id);
                            } else {
                                actions = actions.replace(/\*/g, row.id);
                            }
                            
                            actions = actions.replace(/\<\/a>/g, '<\/a> ');
                            
                            return actions;
                        }
                    }

                    for (let bar of DataTables.TYPES_BAR) {
                        if (this.columns[meta.col].field === bar) {
                            return this.getProgressBar(row[bar]);
                        }
                    }
                    
                    return data;
                },
                class: 'text-right'
            },
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 2 },
            {
                targets: '_all',
                class: 'align-middle',
                render: (data, type, row, meta) => {
                    if (this.RE_DATETIME.test(data)) {
                        return moment(data).utc().format('DD/MM/YYYY HH:mm');
                    }
                    
                    if (row.status_text === data) {
                        return `<span class="badge badge-${row.status_color}">${data}</span>`;
                    }

                    if (String(data).indexOf('Administrador') != -1) {
                        data = data.replace('Administrador', '');
                    }

                    if (row.class_or_resp === data) {
                        if (row.classrooms.length) {
                            return `
                                <a href="/classrooms?classroomID${row.classrooms[0].id}">
                                    ${row.classrooms[0].name}
                                </a>
                            `;
                        } else if (row.responsibles.length) {
                            return `
                                <a href="/responsibles?responsibleID=${row.responsibles[0].id}"> 
                                    ${row.responsibles[0].name}
                                </a>
                            `;
                        }
                        
                        return 'Sem Sala';
                    }

                    if (row.hasOwnProperty('school') && row.school.name  == data) {
                        return `
                            <a href="/schools?schoolID=${row.school.id}">
                                ${row.school.name}
                            </a>
                        `;
                    }

                    for (let bar of DataTables.TYPES_BAR) {
                        if (this.columns[meta.col].data === bar) {
                            return this.getProgressBar(row[bar]);
                        }
                    }

                    return data;
                }
            }
        ];

        options['initComplete'] = this.onDataTablesLoaded.bind(this);
        options['drawCallback'] = this.onDrawCallback.bind(this);

        let customFilters = [];

        if (options.hasOwnProperty('ranges')) {
            for (let r of options['ranges']) {
                customFilters = customFilters.concat(this.getRange(r));
            }
        }

        if (options.hasOwnProperty('sliders')) {
            for (let s of options['sliders']) {
                customFilters = customFilters.concat(this.getSlider(s));
            }
        }

        if (options.hasOwnProperty('selects')) {
            for (let s of options['selects']) {
                customFilters = customFilters.concat(this.getSelect(s));
            }
        }

        options['ajax']['data'] = (d) => {
            for (let o of customFilters) {
                d[o.name] = o.val();
            }
        };

        this.table = $('#table').DataTable(options);
        this.table.buttons().container().appendTo('.tile-body:eq(0)');

        this.table.on('length.dt', (e, settings, len) => {
            sessionStorage.setItem('length', len);
        });

        this.table.on('processing.dt', (e, settings, processing) => {
            if (processing && this.onProcessing) { this.onProcessing(); }
        });

        /* $('.filter')
            .find('input,select')
            .not('[not_filterable],[data-slider-value]')
            .on('change', this.onFilter.bind(this));

        $('.filter')
            .find('.slider .slider-handle')
            .on('mouseup', this.onFilter.bind(this)); */
    }

    hasActions(actions) {
        if (actions) {
            var keys = Object.keys(actions);

            for (let a of keys) {
                if (actions[a] != '') {
                    return true;
                }
            }
        }

        return false;
    }

    events() {
        $("#selectAll").click(function() {
            $('input:checkbox')
                .not(this)
                .not('[name="active"]')
                .prop('checked', this.checked);
        });
    }

    getRange(name) {
        let to = () => { return $(`input[name="${name}0"]`).val(); }
        let from = () => { return $(`input[name="${name}1"]`).val(); }
        
        $(`#${name}RangeDate0, #${name}RangeDate1`).change(() => {
            this.table.draw();
        });

        return [
            { name: `${name}_min`, val: to },
            { name: `${name}_max`, val: from }
        ];
    }

    getSlider(name) {
        let sliderO = $(`#${name}Slider`);
        let value0 = () => { return sliderO.val().split(",")[0]; }
        let value1 = () => { return sliderO.val().split(",")[1]; }
        
        sliderO.on('slideStop', () => {
            this.table.draw();
        });

        return [
            { name: `${name}_min`, val: value0 },
            { name: `${name}_max`, val: value1 }
        ];
    }

    getSelect(name) {
        let select = $(`select[name="${name}"]`);
        let value = () => { return select.val(); }
        
        select.change(() => {
            this.table.draw();
        });
        
        return [{ name: name, val: value }];
    }

    onDataTablesLoaded(e) {
        if ($('#table th:eq(0)').text() === '#') {
            $('#table th:eq(0)').html(`
                <div class="animated-checkbox checkbox-xs-2">
                    <label>
                        <input id="selectAll" type="checkbox">
                        <span class="label-text"></span>
                    </label>
                </div>
            `);
        }

        $('.dataTables_length').parent().removeClass()
            .addClass('col-4 col-xl-2 col-md-3');
        $('.dataTables_filter').parent().removeClass()
            .addClass('col-6 col-xl-4 offset-xl-4 col-md-6 offset-md-1 pr-xs-0');
        $('.dataTables_info').parent().removeClass()
            .addClass('col-12 col-xl-4 text-center text-xl-left');
        $('.dataTables_paginate').parent().removeClass()
            .addClass('col-12 col-xl-8');

        $('.pagination').addClass('justify-content-center justify-content-xl-end');

        if (this.btFilter) {
            var btFilter = `
                <div class="col-2 col-xl-2 pl-0 text-right">
                    <a
                        id="bt-datatable-side-filter"
                        href="javascript:"
                        data-toggle="filter-sidebar"
                        class="btn btn-outline-secondary btn-sm btn-circle 
                            btn-circle-sm btn-table btn-circle-title"
                        title="Filtrar"
                    >
                        <i class="fa fa-filter"></i>
                        <span class="d-none d-lg-inline-block">Filtrar</span>
                    </a>
                </div>
            `;

            $('#table_wrapper .row:eq(0)').append(btFilter);
        }

        $('#bt-datatable-side-filter').click((e) => {
            e.preventDefault();
            $('.app').toggleClass('sidefilter-toggled');
        });

        this.events();
        
        if (this.onCallbackLoaded) {
            this.onCallbackLoaded();
        }
    }

    onDrawCallback(e) {
        window.config.loadPopover();

        if (this.onLoaded) { this.onLoaded(); }
    }

    onBreakpoint(e) {
        var amountBts = 15;

        switch(e.breakpoint) {
            case 'xSmall': amountBts = 4; break;
            case 'small': amountBts = 5; break;
            case 'medium': amountBts = 9; break;
        }

        $.fn.DataTable.ext.pager.numbers_length = amountBts;
    }

    filter(data) {
        for (let filter of data) {
            let sel = $(`select[name="${filter.name}"]`);
            
            if (sel.length) {
                let index = sel.attr('index');

                if (index != undefined) {
                    this.table.column(index).search(filter.value);
                }
            }
        }
        
        this.table.draw();
    }

    getProgressBar(value) {
        const COLOR = this.getProgressColor(value);

        return `
            <div class="progress m-0 p-0 pull-right w-100 user-select-none" title="${value}%">
                <div
                    class="progress-bar bg-${COLOR} progress-bar-striped"
                    role="progressbar"
                    aria-valuenow="${value}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    style="min-width:${value}%;"
                >
                    <div>${value}%</div>
                </div>
            </div>
        `;
    }

    getProgressColor(value) {
        var color = 'danger';

        if (value >= 33 && value <= 70) {
            color = 'warning';
        } else if (value > 70) {
            color = 'success';
        }

        return color;
    }

}