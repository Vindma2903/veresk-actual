@auth
    @php
        $editLink = null;
        $editLinkTitle = null;
        $adminLinks = [
        [
            'Страницы' => route('filament.admin.resources.pages.index'),
            'Услуги' => route('filament.admin.resources.services.index'),
            'Фото услуг'   => route('filament.admin.resources.service-works.index'),
            'Портфолио'   => route('filament.admin.resources.portfolios.index'),
            'Общие настройки'   => route('filament.admin.resources.site-options.index'),
        ],
    ];

    if (isset($entry)) {
        switch (request()->route()->action['as']) {
            case 'services.show':
                $editLink = route('filament.admin.resources.services.edit', ['record' => $entry->id]);
                $editLinkTitle = 'Изменить услугу';
                break;
            case 'pages.show':
                $editLink = route('filament.admin.resources.pages.edit', ['record' => $entry->id]);
                $editLinkTitle = 'Изменить страницу';
                break;
            case 'portfolios.show':
                $editLink = route('filament.admin.resources.portfolios.edit', ['record' => $entry->id]);
                $editLinkTitle = 'Изменить портфолио';
                break;
        }
    }
    @endphp

    <div class="fixed right-2.5 top-[100px]">
        <div class="text-right mb-5">
            <button class="p-3 border bg-slate-700 rounded-full" type="button" data-collapse-id="js-admin-panel">
                <i class="las la-user-secret la-lg"></i>
            </button>
        </div>
        <div class="bg-slate-700 rounded p-4 hidden" id="js-admin-panel">
            <div class="text-sm font-medium text-gray-900 border rounded-lg border-gray-600">
                @if(isset($editLink))
                    <a href="{{$editLink}}" class="w-full block px-4 py-2 border-b border-gray-600 text-white hover:bg-slate-600"><i class="las la-edit"></i> {{$editLinkTitle}}</a>
                @endif
            </div>

            @foreach($adminLinks as $arrAdminLinks)
                <div class="text-sm font-medium text-gray-900 border rounded-lg border-gray-600 mt-5">
                    @foreach($arrAdminLinks as $adminLinkTitle => $adminLink)
                        <a href="{{$adminLink}}" class="w-full block px-4 py-2 border-b border-gray-600 text-white hover:bg-slate-600">{{$adminLinkTitle}}</a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endauth
