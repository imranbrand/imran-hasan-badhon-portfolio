<section id="lab" class="sec">
    <div class="wrap">
        <div class="head rv">
            <p class="label">Vision Lab</p>
            <h2>See an image the way a CNN does.</h2>
            <p class="sub">Real 3&times;3 convolution kernels running live in your browser. Try my portrait or upload your own image, then drag across it to compare. Nothing leaves your device.</p>
        </div>
        <div class="lab rv">
            <div>
                <div class="lab-stage" id="labStage">
                    <canvas id="labA" aria-label="Original image"></canvas>
                    <canvas id="labB" aria-label="Filtered image"></canvas>
                    <div class="lab-split" aria-hidden="true"></div>
                    <span class="lab-tag l" aria-hidden="true">Original</span>
                    <span class="lab-tag r" id="labTag" aria-hidden="true">Edges</span>
                </div>
                <input class="lab-range" id="labRange" type="range" min="0" max="100" value="50" aria-label="Compare original and filtered image">
            </div>
            <div>
                <div class="seg" id="seg" role="group" aria-label="Filter">
                    <button type="button" data-k="edges" aria-pressed="true">Edges</button>
                    <button type="button" data-k="activation" aria-pressed="false">Feature map</button>
                    <button type="button" data-k="emboss" aria-pressed="false">Emboss</button>
                    <button type="button" data-k="sharpen" aria-pressed="false">Sharpen</button>
                    <button type="button" data-k="blur" aria-pressed="false">Blur</button>
                </div>
                <div class="kernel" id="kernel" aria-hidden="true"></div>
                <p class="kernel-cap" id="kernelCap">Sobel kernel (horizontal)</p>
                <p class="lab-note" id="labNote"></p>
                <div class="cta">
                    <button class="btn solid" id="labUpload" type="button">Upload image</button>
                    <button class="btn" id="labReset" type="button">Use my portrait</button>
                </div>
                <input class="sr-only" id="labFile" type="file" accept="image/*" tabindex="-1" aria-label="Choose an image to filter">
                <p class="fine" id="labFine">Processed locally with JavaScript. Nothing is uploaded.</p>
            </div>
        </div>
    </div>
</section>
