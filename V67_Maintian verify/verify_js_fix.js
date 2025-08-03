// --- Verify Tab Functions ---
function searchVerifyTable() {
    const input = document.getElementById('verifySearchInput').value.toLowerCase();
    const items = document.querySelectorAll('.verify-item-list .verify-item');
    if (items.length === 0) {
        console.log('No items to search');
        return;
    }
    items.forEach(item => {
        const titleEl = item.querySelector('.verify-item-title');
        const subtitleEl = item.querySelector('.verify-item-subtitle');
        if (titleEl && subtitleEl) {
            const title = titleEl.textContent.toLowerCase();
            const subtitle = subtitleEl.textContent.toLowerCase();
            if (title.includes(input) || subtitle.includes(input)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        }
    });
}

function cleanVerifySearch() {
    document.getElementById('verifySearchInput').value = '';
    searchVerifyTable();
}

function loadVerifyOptions() {
    fetch('verify_options.php')
        .then(response => response.json())
        .then(options => {
            const selects = {
                'clean_pad_type': options.clean_pad_type,
                'verify_sort': options.verify_sort,
                'verify_method': options.verify_method,
                'rule_verify_pass': options.rule_verify_pass,
                'rule_contact_window': options.rule_contact_window,
                'rule_dib_check': options.rule_dib_check,
            };

            for (const id in selects) {
                const selectElement = document.getElementById(id);
                if (selectElement) {
                    selectElement.innerHTML = '<option value="">請選擇</option>';
                    selects[id].forEach(optionText => {
                        const option = document.createElement('option');
                        option.value = optionText;
                        option.textContent = optionText;
                        selectElement.appendChild(option);
                    });
                }
            }
        })
        .catch(error => console.error('Error loading verify options:', error));
}

function openVerifyModalForEdit(event, id) {
    event.stopPropagation(); // Prevent the preview click from firing

    const itemData = allVerifyData.find(d => d.id === id);
    if (!itemData) {
        showToast('找不到要編輯的資料。');
        return;
    }
    
    // Use the existing modal-opening function
    openVerifyModal(itemData);
}

function openVerifyModal(data) {
    console.log('openVerifyModal called');
    try {
        const modal = document.getElementById('verifyModal');
        if (!modal) {
            console.error('Modal element not found!');
            showToast('找不到 Modal 元素');
            return;
        }
        
        const form = document.getElementById('verifyForm');
        const subtitle = document.getElementById('verifyModalSubtitle');
        const dynamicContainer = document.getElementById('verify-data-section');

        // Reset form for new entry
        form.reset();
        dynamicContainer.innerHTML = '<h3 class="form-section-title">Verify Data</h3>'; // Keep title

        if (data) {
            // Edit mode
            subtitle.textContent = '編輯驗卡資料';
            document.getElementById('verifyId').value = data.id;
            document.getElementById('part6').value = data.part6;
            document.getElementById('device_name').value = data.device_name;
            // (Logic to fill form for editing will be added later)
            
            // Populate dynamic verify data items
            if (data.verify_data && data.verify_data.length > 0) {
                data.verify_data.forEach(vd => addVerifyDataItem(vd));
            }

        } else {
            // New request mode
            subtitle.textContent = '新增驗卡資料';
            document.getElementById('verifyId').value = '';
            // 確保 loadVerifyOptions 已經執行
            const cleanPadSelect = document.getElementById('clean_pad_type');
            if (cleanPadSelect && cleanPadSelect.options.length <= 1) {
                loadVerifyOptions();
            }
            setTimeout(() => {
                addVerifyDataItem(); // Add one default item for a new request
            }, 100);
        }

        modal.style.display = 'block'; // 確保顯示
        modal.classList.add('show');
        console.log('Modal should be visible now');
    } catch (error) {
        console.error('Error opening verify modal:', error);
        showToast('開啟視窗時發生錯誤: ' + error.message);
    }
}

function closeVerifyModal() {
    const modal = document.getElementById('verifyModal');
    modal.classList.remove('show');
}

function addVerifyDataItem(data = null) {
    const container = document.getElementById('verify-data-section');
    const itemIndex = container.querySelectorAll('.dynamic-verify-item').length;
    
    const newItem = document.createElement('div');
    newItem.className = 'dynamic-verify-item';
    newItem.innerHTML = `
        <button type="button" class="delete-item-btn" onclick="this.parentElement.remove()">×</button>
        <div class="form-row">
            <label>Type</label><input type="text" name="verify_data[${itemIndex}][type_name]" placeholder="e.g., Sort1 點測" value="${data?.type_name || ''}">
        </div>
        <div class="form-row" data-columns="2">
            <label>Test Program</label><input type="text" name="verify_data[${itemIndex}][test_program]" value="${data?.test_program || ''}">
            <label>Test OD</label><input type="text" name="verify_data[${itemIndex}][test_od]" value="${data?.test_od || ''}">
        </div>
        <div class="form-row" data-columns="2">
            <label>Prober file</label><input type="text" name="verify_data[${itemIndex}][prober_file]" value="${data?.prober_file || ''}">
            <label>Clean OD</label><input type="text" name="verify_data[${itemIndex}][clean_od]" value="${data?.clean_od || ''}">
        </div>
    `;
    container.appendChild(newItem);
}

function submitVerifyForm(event) {
    event.preventDefault();
    
    try {
        const form = document.getElementById('verifyForm');
        const formData = new FormData(form);
        
        const data = {};
        for (let [key, value] of formData.entries()) {
            // This simple conversion doesn't handle nested objects like verify_data
            if (!key.startsWith('verify_data')) {
                data[key] = value;
            }
        }
        
        data.verify_data = [];
        const verifyItems = form.querySelectorAll('.dynamic-verify-item');
        verifyItems.forEach((item, index) => {
            const type_name = form.querySelector(`[name="verify_data[${index}][type_name]"]`)?.value || '';
            if (type_name) { // Only add if type name is not empty
                data.verify_data.push({
                    type_name: type_name,
                    test_program: form.querySelector(`[name="verify_data[${index}][test_program]"]`)?.value || '',
                    test_od: form.querySelector(`[name="verify_data[${index}][test_od]"]`)?.value || '',
                    prober_file: form.querySelector(`[name="verify_data[${index}][prober_file]"]`)?.value || '',
                    clean_od: form.querySelector(`[name="verify_data[${index}][clean_od]"]`)?.value || ''
                });
            }
        });

        // Basic validation
        if (!data.part6 || !data.device_name) {
            showToast('Part6 和 Device Name 是必填欄位。');
            return;
        }

        fetch('save_verify_data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                showToast(result.message || '儲存成功！');
                closeVerifyModal();
                loadVerifyList(); // Refresh the list on the left
            } else {
                throw new Error(result.message || '儲存失敗。');
            }
        })
        .catch(error => {
            console.error('Error submitting form:', error);
            showToast('提交時發生錯誤: ' + error.message);
        });

    } catch (error) {
        console.error('Error in submitVerifyForm:', error);
        showToast('提交表單時發生客戶端錯誤。');
    }
}

let allVerifyData = []; // Cache for search functionality

function loadVerifyList() {
    fetch('get_verify_list.php')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                allVerifyData = result.data;
                renderVerifyList(allVerifyData);
                
                // Automatically load the first item for preview
                if (allVerifyData.length > 0) {
                    const firstItemId = allVerifyData[0].id;
                    const firstItemElement = document.querySelector(`.verify-item[data-id="${firstItemId}"]`);
                    if (firstItemElement) {
                        firstItemElement.classList.add('active');
                    }
                    displayVerifyPreview(firstItemId);
                }
            } else {
                console.error('Failed to load verify list.');
            }
        })
        .catch(error => console.error('Error loading verify list:', error));
}

function renderVerifyList(data) {
    const container = document.getElementById('verify-list-container');
    container.innerHTML = ''; // Clear existing list

    if (data.length === 0) {
        container.innerHTML = '<div class="no-data">尚無資料</div>';
        return;
    }

    data.forEach(item => {
        const div = document.createElement('div');
        div.className = 'verify-item';
        div.dataset.id = item.id;
        div.innerHTML = `
            <div class="verify-item-content">
                <div class="verify-item-main">
                    <span class="verify-item-title">${item.part6} - ${item.device_name}</span>
                    <span class="verify-item-subtitle">${item.last_updated}</span>
                </div>
            </div>
            <button class="verify-edit-btn" onclick="openVerifyModalForEdit(event, '${item.id}')">Edit</button>
        `;
        
        // Add click listener to the content part, not the whole div
        div.querySelector('.verify-item-content').addEventListener('click', () => {
            // Highlight active item
            document.querySelectorAll('.verify-item').forEach(el => el.classList.remove('active'));
            div.classList.add('active');
            displayVerifyPreview(item.id);
        });
        container.appendChild(div);
    });
}

function displayVerifyPreview(id) {
    const item = allVerifyData.find(d => d.id === id);
    if (!item) return;

    const previewContent = document.getElementById('verify-preview-content');
    const placeholder = document.getElementById('verify-preview-placeholder');

    const updateContent = () => {
        let html = `<div class="preview-inner-content">`; // Wrapper for content
        html += `<table class="preview-table">`;
        html += `<tr><td class="preview-key">Part6</td><td class="preview-value">${item.part6 || ''}</td></tr>`;
        html += `<tr><td class="preview-key">Device_name</td><td class="preview-value">${item.device_name || ''}</td></tr>`;
        html += `<tr><td class="preview-key">PCR Onwer</td><td class="preview-value">${item.pcr_owner || ''}</td></tr>`;
        html += `<tr><td class="preview-key">OTC Onwer</td><td class="preview-value">${item.otc_owner || ''}</td></tr>`;
        html += `<tr><td class="preview-key">RD Onwer</td><td class="preview-value">${item.rd_owner || ''}</td></tr>`;
        html += `</table>`;

        if (item.verify_data && item.verify_data.length > 0) {
            item.verify_data.forEach((vd, index) => {
                html += `<table class="preview-table" style="table-layout: fixed;">`;
                html += `<colgroup>
                            <col style="width: 10.5%;">
                            <col style="width: 45%;">
                            <col style="width: 7%;">
                            <col style="width: 10%;">
                         </colgroup>`;
                html += `<tr>
                            <td class="preview-key">Type${index + 1}</td>
                            <td class="preview-subsection-header" colspan="3">${vd.type_name || ''}</td>
                         </tr>`;
                html += `<tr>
                            <td class="preview-key">Test Program</td><td class="preview-value">${vd.test_program || ''}</td>
                            <td class="preview-key od-key">Test OD</td><td class="preview-value od-content">${vd.test_od || ''}</td>
                         </tr>`;
                html += `<tr>
                            <td class="preview-key">Prober file</td><td class="preview-value">${vd.prober_file || ''}</td>
                            <td class="preview-key od-key">Clean OD</td><td class="preview-value od-content">${vd.clean_od || ''}</td>
                         </tr>`;
                html += `</table>`;
            });
        }

        html += `<table class="preview-table">`;
        html += `<tr><td class="preview-key">Corr Wafer</td><td class="preview-value">${item.corr_wafer || ''}</td></tr>`;
        html += `<tr><td class="preview-key">Clean Pad type</td><td class="preview-value">${item.clean_pad_type || ''}</td></tr>`;
        html += `<tr><td class="preview-key">Verify Sort</td><td class="preview-value">${item.verify_sort || ''}</td></tr>`;
        html += `<tr><td class="preview-key">Verify method</td><td class="preview-value">${item.verify_method || ''}</td></tr>`;
        html += `<tr><td class="preview-key">Rule of verify pass</td><td class="preview-value">${item.rule_verify_pass || ''}</td></tr>`;
        html += `<tr><td class="preview-key">Rule of Contact window</td><td class="preview-value">${item.rule_contact_window || ''}</td></tr>`;
        html += `<tr><td class="preview-key">Rule of DIB check</td><td class="preview-value">${item.rule_dib_check || ''}</td></tr>`;
        html += `<tr><td class="preview-key">General Remark</td><td class="preview-value">${item.general_remark || ''}</td></tr>`;
        html += `</table>`;
        html += `</div>`;

        previewContent.innerHTML = html;
        placeholder.style.display = 'none';
        previewContent.style.display = 'block';

        // Use requestAnimationFrame to ensure the DOM has updated before starting the fade-in.
        requestAnimationFrame(() => {
            previewContent.classList.remove('fading');
        });
    };

    // If the preview is already visible and not currently fading, fade out first.
    if (getComputedStyle(previewContent).display !== 'none' && !previewContent.classList.contains('fading')) {
        previewContent.addEventListener('transitionend', updateContent, { once: true });
        previewContent.classList.add('fading');
    } else {
        // Otherwise, just update the content immediately (handles first load).
        previewContent.classList.add('fading');
        updateContent();
    }
}

// Ensure options and list are loaded on DOMContentLoaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('clean_pad_type')) {
            loadVerifyOptions();
            loadVerifyList();
        }
    });
} else {
    if (document.getElementById('clean_pad_type')) {
        loadVerifyOptions();
        loadVerifyList();
    }
} 