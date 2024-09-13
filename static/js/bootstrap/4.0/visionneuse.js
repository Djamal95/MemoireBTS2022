pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

if (document.getElementById('viewer-emp')) {
    const url = '../../static/progs/' + document.getElementById('document').textContent.trim();
    let pdfDoc = null;
    let scale = 1.5;
    const viewer = document.getElementById('viewer-emp');

    function renderPage(page, scale) {
        const viewport = page.getViewport({ scale });
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderContext = {
            canvasContext: context,
            viewport: viewport
        };

        const pageContainer = document.createElement('div');
        pageContainer.className = 'page';
        pageContainer.appendChild(canvas);
        viewer.appendChild(pageContainer);

        page.render(renderContext).promise.then(() => {
            console.log('Page rendered');
        });
    }

    function renderPages(pdf, scale) {
        viewer.innerHTML = '';
        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            pdf.getPage(pageNum).then(page => {
                renderPage(page, scale);
            });
        }
    }

    pdfjsLib.getDocument(url).promise.then(pdf => {
        pdfDoc = pdf;
        renderPages(pdf, scale);
    }).catch(error => {
        console.error('Error loading PDF:', error);
    });

    document.getElementById('zoom-in').addEventListener('click', () => {
        scale += 0.1;
        if (pdfDoc) {
            renderPages(pdfDoc, scale);
        }
    });
    
    document.getElementById('zoom-out').addEventListener('click', () => {
        scale = Math.max(0.1, scale - 0.1);
        if (pdfDoc) {
            renderPages(pdfDoc, scale);
        }
    });
} else {
    const url = '../../static/docs/' + document.getElementById('document').textContent.trim();
    let pdfDoc = null;
    let scale = 1.5;
    const viewer = document.getElementById('viewer');

    function renderPage(page, scale) {
        const viewport = page.getViewport({ scale });
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderContext = {
            canvasContext: context,
            viewport: viewport
        };

        const pageContainer = document.createElement('div');
        pageContainer.className = 'page';
        pageContainer.appendChild(canvas);
        viewer.appendChild(pageContainer);

        page.render(renderContext).promise.then(() => {
            console.log('Page rendered');
        });
    }

    function renderPages(pdf, scale) {
        viewer.innerHTML = '';
        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            pdf.getPage(pageNum).then(page => {
                renderPage(page, scale);
            });
        }
    }

    pdfjsLib.getDocument(url).promise.then(pdf => {
        pdfDoc = pdf;
        renderPages(pdf, scale);
    }).catch(error => {
        console.error('Error loading PDF:', error);
    });

    document.getElementById('zoom-in').addEventListener('click', () => {
        scale += 0.1;
        if (pdfDoc) {
            renderPages(pdfDoc, scale);
        }
    });
    
    document.getElementById('zoom-out').addEventListener('click', () => {
        scale = Math.max(0.1, scale - 0.1);
        if (pdfDoc) {
            renderPages(pdfDoc, scale);
        }
    });
}