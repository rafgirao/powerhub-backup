// window.onload = function () {
//     document.getElementById("PdfButton")
//         .addEventListener("click", () => {
//             const target = this.document.getElementById("targetPdf");
//             const title = document.getElementById("reportTitle");
//             let date = new Date();
//             let opt = {
//                 margin: 1,
//                 filename: title.innerText + ' Report ' + date.getTime() + ' .pdf',
//                 image: {type: 'jpeg', quality: 1},
//                 html2canvas: {scale: 0.5},
//                 jsPDF: {unit: 'in', format: 'A4', orientation: 'landscape'}
//             };
//             html2pdf().from(target).set(opt).save();
//         })
// }

function HTMLtoPDF() {
    import { jsPDF } from "jspdf";

// Default export is a4 paper, portrait, using millimeters for units
    const doc = new jsPDF();

    doc.text("Hello world!", 10, 10);
    doc.save("a4.pdf");
}



// function HTMLtoPDF() {
//     let doc = new jsPDF
//     let HTMLelement = $(".html_to_pdf").html()
//     doc.html(HTMLelement,10,10,{
//         'width':190
//     })
//     doc.save('meupdf.pdf')
// }
