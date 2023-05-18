<footer class="app-footer">
    <div class="site-footer-right">
        <a href="https://prismatic-technologies.com/" target="_blank">Proudly developed by Prismatic Technologies</a>
        @php $version = Voyager::getVersion(); @endphp
        @if (!empty($version))
            - {{ $version }}
        @endif
    </div>
</footer>

