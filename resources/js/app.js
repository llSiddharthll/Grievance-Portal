import "./bootstrap";

let currentSize = 100; // percentage

const applySize = () => {
    document.documentElement.style.fontSize = currentSize + "%";
};

document.getElementById("increaseFont").addEventListener("click", () => {
    currentSize = Math.min(150, currentSize + 10);
    applySize();
});

document.getElementById("decreaseFont").addEventListener("click", () => {
    currentSize = Math.max(70, currentSize - 10);
    applySize();
});

document.getElementById("resetFont").addEventListener("click", () => {
    currentSize = 100;
    applySize();
});

function formatLabel(text) {
    return text
        .replace(/([A-Z])/g, " $1") // insert spaces before capital letters
        .replace(/^./, (str) => str.toUpperCase()); // capitalize first letter
}

/* ---------------------------------------------
   Convert CHARTS to Images before exporting
----------------------------------------------*/
function getAllChartImages() {
    const charts = document.querySelectorAll("canvas");
    let images = [];

    charts.forEach((chart, index) => {
        images.push({
            id: chart.id,
            src: chart.toDataURL("image/png"),
        });
    });

    return images;
}

/* ---------------------------------------------
    Build FULL REPORT HTML
----------------------------------------------*/
function buildReportHTML() {
    let html = `
        <h1 style="font-size:22px; margin-bottom:10px;">Grievance Dashboard Report</h1>
        <p><strong>Generated:</strong> ${new Date().toLocaleString()}</p>
        <hr><br>

        <h2 style="font-size:18px;">Stats Summary</h2>
        <ul>
            <li>Total Complaints: <strong>${document.querySelector("[data-total]")?.innerText
        }</strong></li>
            <li>Pending Complaints: <strong>${document.querySelector("[data-pending]")?.innerText
        }</strong></li>
            <li>In Progress: <strong>${document.querySelector("[data-progress]")?.innerText
        }</strong></li>
            <li>Resolved Complaints: <strong>${document.querySelector("[data-resolved]")?.innerText
        }</strong></li>
        </ul>
        <br>
        <h2 style="font-size:18px;">Charts</h2>
    `;

    const chartImages = getAllChartImages();
    chartImages.forEach((img) => {
        html += `
<div style="margin:20px 0;">
    <h3>${formatLabel(img.id)}</h3>
    <img src="${img.src}" style="width:100%; max-width:600px;" />
</div>
`;
    });

    return html;
}

/* ---------------------------------------------
    DOWNLOAD AS PDF
----------------------------------------------*/
document.getElementById("downloadPdfBtn").addEventListener("click", () => {
    const reportHTML = buildReportHTML();

    const element = document.createElement("div");
    element.innerHTML = reportHTML;

    const opt = {
        margin: 10,
        filename: "dashboard-report.pdf",
        html2canvas: {
            scale: 2
        },
        jsPDF: {
            unit: "mm",
            format: "a4",
            orientation: "portrait"
        },
    };

    html2pdf().from(element).set(opt).save();
});

/* ---------------------------------------------
    DOWNLOAD AS WORD (.doc)
----------------------------------------------*/
document.getElementById("downloadWordBtn").addEventListener("click", () => {
    const reportHTML = buildReportHTML();

    const header = `
<html xmlns:o='urn:schemas-microsoft-com:office:office'
      xmlns:w='urn:schemas-microsoft-com:office:word'
      xmlns='http://www.w3.org/TR/REC-html40'>
<head><meta charset='utf-8'>
<style>
img { 
    max-width: 600px; 
    height: auto;
}
</style>
</head><body>
`;

    const footer = "</body></html>";

    const blob = new Blob([header + reportHTML + footer], {
        type: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    });

    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "dashboard-report.doc";
    link.click();
});
