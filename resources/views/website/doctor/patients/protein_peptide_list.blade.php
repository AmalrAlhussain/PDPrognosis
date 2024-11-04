<div class="row">
    <!-- Proteins Card -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <span><i class="fa fa-dna" aria-hidden="true"></i> Proteins</span>
                <select id="sortProteins" class="form-control form-control-sm w-auto">
                    <option value="npx_asc">Sort by NPX Ascending</option>
                    <option value="npx_desc">Sort by NPX Descending</option>
                </select>
            </div>
            <div class="card-body">
                <ul id="proteinList" class="list-group">
                    @foreach($proteins as $protein)
                        <li class="list-group-item protein-item" data-npx="{{ $protein->NPX }}">
                            <strong>UniProt:</strong> {{ $protein->UniProt }} <br>
                            <strong>NPX:</strong> {{ $protein->NPX }}
                            <div class="mt-2">
                                <a href="https://www.uniprot.org/uniprotkb/{{ $protein->UniProt }}" target="_blank" class="btn btn-primary btn-sm">
                                    View UniProt
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Peptides Card -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <span><i class="fa fa-vial" aria-hidden="true"></i> Peptides</span>
                <select id="sortPeptides" class="form-control form-control-sm w-auto">
                    <option value="abundance_asc">Sort by Abundance Ascending</option>
                    <option value="abundance_desc">Sort by Abundance Descending</option>
                </select>
            </div>
            <div class="card-body">
                <ul id="peptideList" class="list-group">
                    @foreach($peptides as $peptide)
                        <li class="list-group-item peptide-item" data-abundance="{{ $peptide->PeptideAbundance }}">
                            <strong>UniProt:</strong> {{ $peptide->UniProt }} <br>
                            <strong>Peptide:</strong> {{ $peptide->Peptide }} <br>
                            <strong>Abundance:</strong> {{ $peptide->PeptideAbundance }}
                            <div class="mt-2">
                                <a href="https://www.uniprot.org/peptide-search?peps={{ $peptide->Peptide }}" target="_blank" class="btn btn-primary btn-sm">
                                    View UniProt
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for sorting functionality -->
<script>
    // Sorting function for Proteins
    document.getElementById('sortProteins').addEventListener('change', function () {
        const order = this.value;
        let items = Array.from(document.querySelectorAll('.protein-item'));

        items.sort((a, b) => {
            const npxA = parseFloat(a.getAttribute('data-npx'));
            const npxB = parseFloat(b.getAttribute('data-npx'));

            return order === 'npx_asc' ? npxA - npxB : npxB - npxA;
        });

        // Append sorted items to the list
        const proteinList = document.getElementById('proteinList');
        proteinList.innerHTML = '';
        items.forEach(item => proteinList.appendChild(item));
    });

    // Sorting function for Peptides
    document.getElementById('sortPeptides').addEventListener('change', function () {
        const order = this.value;
        let items = Array.from(document.querySelectorAll('.peptide-item'));

        items.sort((a, b) => {
            const abundanceA = parseFloat(a.getAttribute('data-abundance'));
            const abundanceB = parseFloat(b.getAttribute('data-abundance'));

            return order === 'abundance_asc' ? abundanceA - abundanceB : abundanceB - abundanceA;
        });

        // Append sorted items to the list
        const peptideList = document.getElementById('peptideList');
        peptideList.innerHTML = '';
        items.forEach(item => peptideList.appendChild(item));
    });
</script>
