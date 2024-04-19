
<form
          id="modal"
          class="register-form modal"
          action="./fuggvenyek/termek_beszuras.php"
          method="POST"
          enctype="multipart/form-data"
        >
          <h2>Termék hozzáadása</h2>
          <div class="nev-container">
          <div class="form-item">
            <label class="form-label" for="nev">Termék neve</label>
            <input
              class="form-input"
              type="text"
              id="nev"
              name="nev"
              required
              placeholder="Termék neve..."
            />
          </div>
          <div class="form-item">
            <label class="form-label" for="ar"
              >Termék ára</label
            >
            <input
              class="form-input"
              type="text"
              id="ar"
              name="ar"
              required
              placeholder="Termék ára..."
            />
          </div>
          </div>

          <div class="nev-container">
            <div class="form-item">
              <label class="form-label" for="meret"
                >Termék mérete</label
              >
              <input
                class="form-input"
                type="text"
                id="meret"
                name="meret"
                required
                placeholder="Termék mérete..."
              />
            </div>
            <div class="nev-container">
            <div class="form-item">
              <label class="form-label" for="mennyiseg"
                >Elérhető mennyiség</label
              >
              <input
                class="form-input"
                type="text"
                id="mennyiseg"
                name="mennyiseg"
                required
                placeholder="Elérhető mennyiség..."
              />
            </div>
          </div>

          <div class="form-item">
            <label class="form-label" for="leiras">Termék típusa</label>
            <input
              class="form-input"
              type="text"
              id="tipus"
              name="tipus"
              required
              placeholder="Termék típusa..."
            />
          </div>
            </div>
          <div class="form-item">
            
            <textarea name="leiras" id="leiras" class="w-full" rows="10" placeholder="Termék leírása..."></textarea>

           
          </div>
          <div class="form-item col">
          <div class="btn row ">
          <label for="kep">Kép a termékről</label>
            <input type="file" name="kep" id="kep" >
          </div>
          </div>

         <div class="row justify-between w-full">
          <button class="btn">Hozzáadás</button>
          <button class="btn eltavolitas-btn">Mégse</button>

         </div>
        </form>
