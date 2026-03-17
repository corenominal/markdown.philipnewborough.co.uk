<?= $this->extend('templates/default') ?>

<?= $this->section('content') ?>
<div id="converter-wrapper" class="container">

    <div id="converter-header" class="">
        <div class="mb-3 pb-2 d-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0">Markdown Converter</h1>
            <button id="download-md-btn" class="btn btn-sm btn-outline-primary" title="Download as Markdown file" disabled>
                <i class="bi bi-download me-lg-1"></i> <span class="d-none d-lg-inline-block">Download .md</span>
            </button>
        </div>
        <ul class="nav nav-tabs" id="converterTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="markdown-tab" data-bs-toggle="tab" data-bs-target="#markdown-pane" type="button" role="tab" aria-controls="markdown-pane" aria-selected="true">Markdown</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="html-tab" data-bs-toggle="tab" data-bs-target="#html-pane" type="button" role="tab" aria-controls="html-pane" aria-selected="false" disabled>HTML</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview-pane" type="button" role="tab" aria-controls="preview-pane" aria-selected="false" disabled>Preview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="syntax-tab" data-bs-toggle="tab" data-bs-target="#syntax-pane" type="button" role="tab" aria-controls="syntax-pane" aria-selected="false">Help</button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="converterTabContent">

        <!-- Markdown panel -->
        <div class="tab-pane fade show active" id="markdown-pane" role="tabpanel" aria-labelledby="markdown-tab" tabindex="0">
            <textarea id="markdown-input" class="w-100 border-0 py-4 font-monospace" placeholder="Type or paste your Markdown here..." spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off"></textarea>
        </div>

        <!-- HTML panel -->
        <div class="tab-pane fade" id="html-pane" role="tabpanel" aria-labelledby="html-tab" tabindex="0">
            <textarea id="html-output" class="w-100 border-0 py-4 font-monospace" readonly placeholder="Converted HTML will appear here..."></textarea>
        </div>

        <!-- Preview panel -->
        <div class="tab-pane fade overflow-auto" id="preview-pane" role="tabpanel" aria-labelledby="preview-tab" tabindex="0">
            <div id="preview-output" class="py-4 markdown-preview"></div>
        </div>

        <!-- Syntax panel -->
        <div class="tab-pane fade overflow-auto" id="syntax-pane" role="tabpanel" aria-labelledby="syntax-tab" tabindex="0">
            <div class="py-4" id="syntax-guide">

                <h2 class="h5 mb-4 text-secondary">Editor Usage</h2>
                <div class="row g-4 mb-5">

                    <div class="col-lg-6">

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Keyboard Shortcuts</div>
                            <div class="card-body pb-2">
                                <table class="table table-sm table-borderless mb-0 small">
                                    <tbody>
                                        <tr><td class="text-nowrap pe-3"><kbd>Tab</kbd></td><td>Insert 4 spaces</td></tr>
                                        <tr><td class="text-nowrap pe-3"><kbd>Tab</kbd> <span class="text-secondary">(selection)</span></td><td>Indent selected lines by 4 spaces</td></tr>
                                        <tr><td class="text-nowrap pe-3"><kbd>Shift</kbd>+<kbd>Tab</kbd> <span class="text-secondary">(selection)</span></td><td>Outdent selected lines</td></tr>
                                        <tr><td class="text-nowrap pe-3"><kbd>Ctrl</kbd>/<kbd>⌘</kbd>+<kbd>B</kbd></td><td>Toggle <strong>bold</strong> on selection</td></tr>
                                        <tr><td class="text-nowrap pe-3"><kbd>Ctrl</kbd>/<kbd>⌘</kbd>+<kbd>I</kbd></td><td>Toggle <em>italic</em> on selection</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Backtick Shortcuts</div>
                            <div class="card-body pb-2">
                                <p class="small text-secondary mb-2">Select text and press <kbd>`</kbd> to wrap it in inline code backticks.</p>
                                <p class="small text-secondary mb-0">Type <code>``<wbr>`</code> (three backticks) to insert a fenced code block with the cursor placed inside, ready to type.</p>
                            </div>
                        </div>

                    </div><!-- /.col-lg-6 -->

                    <div class="col-lg-6">

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Smart Lists &amp; Blockquotes</div>
                            <div class="card-body pb-2">
                                <p class="small text-secondary mb-2">Press <kbd>Enter</kbd> at the end of a list item to automatically start the next item. Ordered lists auto-increment the number.</p>
                                <p class="small text-secondary mb-2">Press <kbd>Enter</kbd> on a blockquote line to continue the <code>&gt;</code> prefix on the next line.</p>
                                <p class="small text-secondary mb-0">Press <kbd>Enter</kbd> on an empty list item or blockquote line to exit the structure.</p>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Word Expanders</div>
                            <div class="card-body pb-2">
                                <p class="small text-secondary mb-2">Type a trigger word then press <kbd>Space</kbd> or <kbd>Tab</kbd> to expand it. Triggers are case-insensitive.</p>
                                <table class="table table-sm table-borderless mb-0 small">
                                    <tbody>
                                        <tr><td class="text-nowrap pe-3"><code>lorem</code></td><td>Expands to a Lorem Ipsum paragraph</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div><!-- /.col-lg-6 -->

                </div><!-- /.row -->

                <h2 class="h5 mb-4 text-secondary">GitHub Flavored Markdown Reference</h2>
                <div class="row g-4">

                    <div class="col-lg-6">

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Headings</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code># Heading 1
## Heading 2
### Heading 3
#### Heading 4
##### Heading 5
###### Heading 6</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Emphasis</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>**Bold text**  or  __Bold text__
*Italic text*  or  _Italic text_
***Bold and italic***
~~Strikethrough~~</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Blockquotes</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>> This is a blockquote.
>
> It can span multiple paragraphs.
>
> > Nested blockquote.</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Unordered Lists</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>- Item one
- Item two
  - Nested item
  - Nested item
- Item three

* Asterisk also works
+ Plus sign also works</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Ordered Lists</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>1. First item
2. Second item
3. Third item
   1. Nested ordered
   2. Nested ordered</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Task Lists <span class="badge text-bg-secondary fw-normal ms-1">GFM</span></div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>- [x] Completed task
- [ ] Incomplete task
- [x] Another completed task</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Horizontal Rule</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>---
***
___</code></pre>
                        </div>

                    </div><!-- /.col-lg-6 -->

                    <div class="col-lg-6">

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Links</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>[Link text](https://example.com)
[With title](https://example.com "Title")

[Reference link][my-ref]

[my-ref]: https://example.com</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Images</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>![Alt text](image.jpg)
![Alt text](image.jpg "Optional title")

![Reference image][img-id]

[img-id]: image.jpg</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Inline Code &amp; Code Blocks</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>Use `backticks` for inline code.

```javascript
const greet = (name) => {
  console.log(`Hello, ${name}!`);
};
```

```python
def hello(name):
    print(f"Hello, {name}!")
```</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Tables <span class="badge text-bg-secondary fw-normal ms-1">GFM</span></div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>| Header   | Header   | Header   |
|----------|----------|----------|
| Cell     | Cell     | Cell     |
| Cell     | Cell     | Cell     |

Alignment:

| Left     | Center   | Right    |
|:---------|:--------:|---------:|
| text     | text     | text     |</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Autolinks <span class="badge text-bg-secondary fw-normal ms-1">GFM</span></div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>https://example.com becomes a link.
user@example.com becomes a mailto link.</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Escaping Special Characters</div>
                            <pre class="p-3 mb-0 rounded-bottom syntax-block"><code>\# Not a heading
\*Not italic\*
\`Not inline code\`
\[Not a link\](url)</code></pre>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header fw-semibold">Paragraphs &amp; Line Breaks</div>
                            <div class="card-body pb-2">
                                <p class="small text-secondary mb-2">Separate text with a blank line to create a new paragraph.</p>
                                <p class="small text-secondary mb-0">End a line with two or more spaces, then press enter for a line break within a paragraph.</p>
                            </div>
                        </div>

                    </div><!-- /.col-lg-6 -->

                </div><!-- /.row -->
            </div><!-- /#syntax-guide -->
        </div><!-- /#syntax-pane -->

    </div><!-- /#converterTabContent -->

</div><!-- /#converter-wrapper -->
<?= $this->endSection() ?>