<div>


    {{-- <style>
        .fingerprint_label {
            display: none;
        }
        @media print {
            img {
                height: 10vh !important;
            }
            table {
                width: 100% !important;
                /* margin-left: -100px; */
            }
            #brightnessRange,
            #contrastRange,
            .hide {
                display: none;
            }
        }
    </style> --}}

    <style>
        .fingerprint_label{
            text-align: center;
        }
        /* img{
            margin-left: 12% !important;
        } */
    </style>



    <div class="relative overflow-x-auto hide" id="upload_section">
        <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" wire:submit="save">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Upload Zip
                </label>
                <input wire:model="zip" id="{{ $id }}"
                    class="shadow appearance-none rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="username" style="float:left;" type="file" placeholder="Username" required accept=".zip" />




                <button wire:loading.attr="disabled" wire:target="save, zip"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    style="float:left;" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                    wire:loading.class.remove="hover:bg-blue-700">
                    <span wire:loading wire:target="save">Processing Zip..</span>
                   <span wire:loading.remove wire:target="save, zip">Upload</span>
                     <span wire:loading wire:target="zip">Uploading...</span>
                </button>



                @error('zip')
                    <br>
                    <br>
                    <p style="float:left; color:red;"> {{ $message }} </p>
                @enderror



            </div>

        </form>

    </div>


    <div>


        <div class="hide py-6 mb-20 mx-8">
            <button
                class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hide"
                style="float:left;" type="button" id="exportPdf">
                Download PDF
            </button>

            <button
                class="mx-2 bg-orange-600 hover:bg-orange-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hide"
                style="float:left;" type="button" id="exportIllustration">
                Download Illustration
            </button>

            <button
                class="bg-red-500 hover:bg-red-700 text-white  font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hide"
                style="float:right;" type="button" id="download_pdf_btn" wire:click="delete">
                Delete
            </button>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 light:text-gray-400 printTable"
            style="text-align:center;" id="myTable">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 light:bg-gray-700 light:text-gray-400 visible">
                <tr class="visible">
                    <th scope="col" class="px-6 py-3 visible ">
                        Candidate Name
                    </th>
                    <th scope="col" class="px-6 py-3 visible">
                        Marksheet
                    </th>
                    <th scope="col" class="px-6 py-3 visible">
                        Certificate
                    </th>
                    <th scope="col" class="px-6 py-3 visible">
                        Skill Card
                    </th>

                    <th scope="col" class="px-6 py-3 visible">
                        Others
                    </th>

                    <th scope="col" class="px-6 py-3 visible" style="display:none;">
                        Others
                    </th>
                    <th scope="col" class="px-6 py-3 visible hide">
                        Manage Brightness
                    </th>
                    <th scope="col" class="px-6 py-3 visible hide">
                        Manage Contrast
                    </th>

                    <th scope="col" class="px-6 py-3 visible hide">
                        Forced High Quality
                    </th>

                </tr>
            </thead>
            <tbody id="table_export">



                @if (@$data !== null)
                    @foreach ($data as $d)
                        @php
                            $parts = explode('(', $d->name);
                            $name = isset($parts[0]) ? $parts[0] : '';
                            $number = isset($parts[1]) ? '(' . $parts[1] : '';
                        @endphp

                        <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 visible" id="">
                            <td class="user_name">{{ $name }}<br>{{ $number }}</td>
                            <td align="center">
                                <img src="{{ asset('storage/' . $d->img_1) }}" id="marksheetImage_{{ $d->id }}"
                                    style="height:20vh; margin:10px; " alt="Image Not Found">
                                <span class="fingerprint_label">{{ $name }}<br>{{ $number }}</span>
                            </td>

                            <td align="center">
                                <img src="{{ asset('storage/' . $d->img_2) }}" style="height:20vh; margin:10px;"
                                    alt="Image Not Found">
                                <span class="fingerprint_label">{{ $name }}<br>{{ $number }}</span>
                            </td>


                            <td align="center">
                                <img src="{{ asset('storage/' . $d->img_3) }}" style="height:20vh; margin:10px;"
                                    alt="Image Not Found">
                                <span class="fingerprint_label">{{ $name }}<br>{{ $number }}</span>
                            </td>

                            <td align="center">
                                <img src="{{ asset('storage/' . $d->img_4) }}" style="height:20vh; margin:10px;"
                                    alt="Image Not Found">
                                <span class="fingerprint_label">{{ $name }}<br>{{ $number }}</span>
                            </td>

                            {{-- <td style="width:30px;">
                                <img src="{{ asset('storage/' . $d->img_5) }}" style="height:20vh; display:none; margin:10px;" class="last_img"
                                    alt="Image Not Found">
                                <span class="fingerprint_label" style="text-align: center;">{{ $name }}<br>{{ $number }}</span>
                            </td> --}}

                            <td id="brightnessRange">
                                <input type="range" name="" min="0" value="100" max="200"
                                    id="" class="brightness-slider">
                            </td>

                            <td id="contrastRange">
                                <input type="range" name="" min="0" value="100" max="200"
                                    id="" class="contrast-slider">
                            </td>

                            <td id="high-quality-checkbox hide">
                                <input type="checkbox" id="" class="high-quality-checkbox hide">
                            </td>

                        </tr>
                    @endforeach
                @endif




            </tbody>
        </table>
    </div>




    {{-- <div id="result">
        <!-- Result will appear be here -->
     </div> --}}


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/html2canvas.js') }}"></script> --}}

     <style>
         /* table tr{ background: rgb(245,245,245) !important ;  } */
     </style>

    <script>
        // Event listener for #exportPdf button
        document.getElementById('exportPdf').addEventListener('click', function() {
            // Apply the print style that hides certain elements
            var style = document.createElement('style');
            style.textContent = `
        .fingerprint_label { display: none; }
        @media print {
            img { height: 10vh !important; height:auto; width:80% !important; margin:0px !important; margin-top:5px !important;   margin-bottom: 5px !important; clip-path: polygon(5% 6%, 95% 5%, 95% 95%, 6% 95%); }
            table { width: 100% !important; border:1px #e5e7eb black !important  }
            table tr { border-top:1px solid black !important; border-bottom:1px solid black !important;   }
            table tr td { border-left:1px solid black !important; margin:10px; }
            table tr th { border:1px solid black !important  }
            .shadow-sm{ box-shadow: none !important; }
            #brightnessRange, #contrastRange, .hide { display: none; border:none !important; }
        }
    `;
            document.head.appendChild(style);

            // Trigger the print functionality
            window.print();

            // Remove the print style after printing
            document.head.removeChild(style);
        });

        // Event listener for #exportIllustration button
        document.getElementById('exportIllustration').addEventListener('click', function() {
            // Apply the print style that shows certain elements
            var style = document.createElement('style');
            style.textContent = `
        .fingerprint_label { display: none; }
        @media print {
            table{ background-color: rgba(0,0,0,0.5) !important ;  }
            img { height: 10vh !important; border:none !important;  clip-path: polygon(5% 6%, 95% 5%, 95% 95%, 6% 95%); }
            table { width: 100% !important; margin-top:-35px;  background: rgb(245,245,245) !important ; }
            table tr{ border:none !important }
            table tr td{ border:none !important; }
            table tr td img{ border:none !important }
            // .last_img{margin-left:30px !important;}
            #brightnessRange, #contrastRange, .hide { display: none !important; } .fingerprint_label {  display: block !important; } th  { display: none !important; }
            .user_name  { display: none !important; }
            .shadow-sm{ box-shadow: none !important; }
        }
    `;
            document.head.appendChild(style);

            // Trigger the print functionality
            window.print();

            // Remove the print style after printing
            document.head.removeChild(style);
        });



        // document.getElementById('exportIllustration').addEventListener('click', function() {
        //     var table = document.getElementById("table_export");

        //     // Create a clone of the table with its styles
        //     var tableClone = table.cloneNode(true);
        //     tableClone.style.position = 'absolute';
        //     // tableClone.style.top = '-9999px'; // Move the clone off-screen
        //     document.body.appendChild(tableClone); // Append the clone to the body

        //     // Capture the cloned table with its styles
        //     html2canvas(tableClone, {
        //         scrollX: 0,
        //         scrollY: -window.scrollY, // Ensure capturing from the top of the table
        //         windowWidth: document.documentElement.scrollWidth, // Capture the entire width of the table
        //         windowHeight: document.documentElement.scrollHeight + 100, // Capture the entire height of the table
        //         onrendered: function(canvas) {
        //             // Convert canvas to data URL
        //             var img = canvas.toDataURL("image/png");

        //             // Create a temporary anchor element
        //             var a = document.createElement('a');
        //             a.href = img;
        //             a.download = 'table_capture.png';

        //             // Programmatically trigger the download
        //             a.click();

        //             // Clean up: Remove the cloned table from the document body
        //             document.body.removeChild(tableClone);
        //         }
        //     });
        // });
    </script>




    <script>
        function toggleHighQuality(targetId) {
            let childs = $(targetId).parent().parent().children();
            for (let i = 1; i <= 5; i++) {
                let image = $(childs[i]).children()[0];
                if (image.style.imageRendering === 'pixelated') {
                    image.style.imageRendering = 'auto';
                } else {
                    image.style.imageRendering = 'pixelated';
                }
            }
        }



        function adjustBrightness(targetId, brightnessValue) {
            let childs = $(targetId).parent().parent().children();
            for (let i = 1; i <= 5; i++) {
                let image = $(childs[i]).children()[0];
                let currentFilter = image.style.filter;
                // Remove existing brightness filter if it exists
                currentFilter = currentFilter.replace(/brightness\(\d+%\)/g, '');
                image.style.filter = currentFilter + ` brightness(${brightnessValue}%)`;
            }
        }

        function adjustContrast(targetId, contrastValue) {
            let childs = $(targetId).parent().parent().children();
            for (let i = 1; i <= 5; i++) {
                let image = $(childs[i]).children()[0];
                let currentFilter = image.style.filter;
                // Remove existing contrast filter if it exists
                currentFilter = currentFilter.replace(/contrast\(\d+%\)/g, '');
                image.style.filter = currentFilter + ` contrast(${contrastValue}%)`;
            }
        }


        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('input', function(event) {
                var slider = event.target;
                if (slider.classList.contains('brightness-slider')) {
                    var targetId = slider.dataset.target;
                    var value = slider.value;
                    adjustBrightness(slider, value);
                } else if (slider.classList.contains('contrast-slider')) {
                    var targetId = slider.dataset.target;
                    var value = slider.value;
                    adjustContrast(slider, value);
                } else if (slider.classList.contains('high-quality-checkbox')) {
                    var targetId = slider.dataset.target;
                    var value = slider.value;
                    toggleHighQuality(slider, value);
                }
            });
        });
    </script>


</div>
