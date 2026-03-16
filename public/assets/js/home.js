(function () {
    'use strict';

    const STORAGE_KEY = 'markdown_converter_content';

    const markdownInput = document.getElementById('markdown-input');
    const htmlOutput    = document.getElementById('html-output');
    const previewOutput = document.getElementById('preview-output');
    const tabContent    = document.getElementById('converterTabContent');
    const htmlTab       = document.getElementById('html-tab');
    const previewTab    = document.getElementById('preview-tab');
    const downloadBtn   = document.getElementById('download-md-btn');

    // Restore from localStorage on page load
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) {
        markdownInput.value = saved;
        setConvertTabsState(true);
    }

    // Save to localStorage on input and toggle convert tabs
    markdownInput.addEventListener('input', function () {
        const hasContent = this.value.trim().length > 0;
        localStorage.setItem(STORAGE_KEY, this.value);
        setConvertTabsState(hasContent);
    });

    // Fetch fresh conversion whenever HTML or Preview tab is activated
    document.getElementById('html-tab').addEventListener('show.bs.tab', function () {
        fetchConverted(false);
    });

    document.getElementById('preview-tab').addEventListener('show.bs.tab', function () {
        fetchConverted(true);
    });

    function setConvertTabsState(enabled) {
        htmlTab.disabled     = !enabled;
        previewTab.disabled  = !enabled;
        downloadBtn.disabled = !enabled;
    }

    async function fetchConverted(isPreview) {
        const markdown = markdownInput.value;
        if (!markdown.trim()) return;

        try {
            const response = await fetch('/convert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ markdown }),
            });

            const data = await response.json();

            if (!response.ok) {
                const msg = data.error || 'Conversion failed';
                if (isPreview) {
                    previewOutput.innerHTML = '<div class="alert alert-danger mt-3">Error: ' + escapeHtml(msg) + '</div>';
                } else {
                    htmlOutput.value = 'Error: ' + msg;
                }
                return;
            }

            if (isPreview) {
                previewOutput.innerHTML = data.html;
            } else {
                htmlOutput.value = data.html;
            }
        } catch (e) {
            const msg = e.message || 'Network error';
            if (isPreview) {
                previewOutput.innerHTML = '<div class="alert alert-danger mt-3">Error: ' + escapeHtml(msg) + '</div>';
            } else {
                htmlOutput.value = 'Error: ' + msg;
            }
        }
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    downloadBtn.addEventListener('click', function () {
        const content = markdownInput.value;
        if (!content.trim()) return;

        const words = content.trim()
            .replace(/^[\s#>\-*+]+/, '')
            .replace(/[^\w\s]/g, '')
            .split(/\s+/)
            .filter(Boolean)
            .slice(0, 5)
            .join('-')
            .toLowerCase();

        const filename = words ? words + '.md' : 'markdown.md';
        const blob = new Blob([content], { type: 'text/markdown' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        a.click();
        URL.revokeObjectURL(url);
    });

    const markdownToolbar = document.getElementById('markdown-toolbar');

    // Size the tab content to fill the space between the header and footer
    function resizeEditor() {
        requestAnimationFrame(function () {
            const footer       = document.querySelector('footer');
            const footerHeight = footer ? footer.offsetHeight : 0;
            const rect         = tabContent.getBoundingClientRect();
            const height       = window.innerHeight - rect.top - footerHeight;
            const pxHeight     = Math.max(200, Math.floor(height));
            tabContent.style.height = pxHeight + 'px';

            if (markdownToolbar && markdownInput) {
                markdownInput.style.height = Math.max(100, pxHeight - markdownToolbar.offsetHeight) + 'px';
            }
        });
    }

    window.addEventListener('resize', resizeEditor);
    window.addEventListener('load', resizeEditor);
    resizeEditor();

}());
