<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('cart_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.carts.unpaid") }}" class="c-sidebar-nav-link {{ request()->is("admin/carts/unpaid") || request()->is("admin/carts/unpaid*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-shopping-cart c-sidebar-nav-icon"></i>{{ trans('cruds.cart.unpaid.title') }}
                </a>
            </li>
        @endcan
        @can('transaction_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/checkouts*") ? "c-show" : "" }} {{ request()->is("admin/withdrawls*") ? "c-show" : "" }} {{ request()->is("admin/balances*") ? "c-show" : "" }} {{ request()->is("admin/transactions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-exchange-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.transactionManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('checkout_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.checkouts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/checkouts") || request()->is("admin/checkouts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-receipt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.checkout.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('withdrawl_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.withdrawls.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/withdrawls") || request()->is("admin/withdrawls/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-dollar-sign c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.withdrawl.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('balance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.balances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/balances") || request()->is("admin/balances/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-hand-holding-usd c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.balance.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('transaction_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.transactions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/transactions") || request()->is("admin/transactions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-exchange-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.transaction.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/user-statistics*") ? "c-show" : "" }} {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    {{-- @can('user_statistic_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user-statistics.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-statistics") || request()->is("admin/user-statistics/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-chart-pie c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.userStatistic.title') }}
                            </a>
                        </li>
                    @endcan --}}
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('hardware_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/hardware-items*") ? "c-show" : "" }} {{ request()->is("admin/hardware-types*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-hdd c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.hardware.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('hardware_item_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.hardware-items.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/hardware-items") || request()->is("admin/hardware-items/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-hdd c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.hardwareItem.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('hardware_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.hardware-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/hardware-types") || request()->is("admin/hardware-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-keyboard c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.hardwareType.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('contract_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/contracts*") ? "c-show" : "" }} {{ request()->is("admin/contract-periods*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-file-signature c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.contractManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('contract_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.contracts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contracts") || request()->is("admin/contracts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-contract c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.contract.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('contract_period_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.contract-periods.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contract-periods") || request()->is("admin/contract-periods/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-calendar-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.contractPeriod.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('support_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/messages*") ? "c-show" : "" }} {{ request()->is("admin/chats*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-life-ring c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.support.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('message_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.messages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/messages") || request()->is("admin/messages/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-comments c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.message.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('chat_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.chats.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/chats") || request()->is("admin/chats/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-comment-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.chat.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('blog_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/categories*") ? "c-show" : "" }} {{ request()->is("admin/articles*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fab fa-blogger-b c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.blogManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-folder c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.category.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('article_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.articles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/articles") || request()->is("admin/articles/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.article.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('faq_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/faqs*") ? "c-show" : "" }} {{ request()->is("admin/faq-categories*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-question-circle c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.faqManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('faq_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faqs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faqs") || request()->is("admin/faqs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-align-justify c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.faq.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('faq_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faq-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faq-categories") || request()->is("admin/faq-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-sitemap c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.faqCategory.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('review_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.reviews.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/reviews") || request()->is("admin/reviews/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-star c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.review.title') }}
                </a>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link {{ request()->is('page') ? 'c-active' : '' }}" href="{{ route('admin.page.index') }}">
                <i class="fa-fw fas fa-file c-sidebar-nav-icon">
                </i>
                All Pages Title
            </a>
        </li>
        @can('content_page_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.about-page.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/about-page") || request()->is("admin/about-page/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-file c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.aboutPage.title') }}
                </a>
            </li>
        @endcan
        @can('content_page_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.content-pages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/content-pages") || request()->is("admin/content-pages/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-file c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.contentPage.title') }}
                </a>
            </li>
        @endcan
        @can('contact_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.contacts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contacts") || request()->is("admin/contacts/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-headset c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.contact.title') }}
                </a>
            </li>
        @endcan
        @can('currency_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.currencies.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/currencies") || request()->is("admin/currencies/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-money-bill-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.currency.title') }}
                </a>
            </li>
        @endcan
        @can('setting_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/settings") || request()->is("admin/settings/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setting.title') }}
                </a>
            </li>
        @endcan
        @can('wallets_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/wallets*") ? "c-show" : "" }} {{ request()->is("admin/wallet-networks*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-wallet c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.walletsManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('wallet_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.wallets.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/wallets") || request()->is("admin/wallets/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-wallet c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.wallet.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('wallet_network_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.wallet-networks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/wallet-networks") || request()->is("admin/wallet-networks/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-bezier-curve c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.walletNetwork.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('language_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.languages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/languages") || request()->is("admin/languages/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-globe c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.language.title') }}
                </a>
            </li>
        @endcan
        @can('mail_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.mails.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/mails") || request()->is("admin/mails/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.mail.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
