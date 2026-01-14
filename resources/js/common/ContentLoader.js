import $ from "jquery";

export class ContentLoader {
  /**
   * options.url
   * options.containerName
   * options.loadingLabel
   * options.errorLabel
   * @param options
   */
  constructor(options) {
    if(!options.hasOwnProperty("containerName") || !options.hasOwnProperty("url"))
      throw new Error("Defina correctamente containerName y url");

    this.loaded = false;
    this.url = options.url;
    this.loadingLabel = options.loadingLabel || "Cargando...";
    this.errorLabel = options.errorLabel || "Error al cargar datos";
    this.container = $(options.containerName);
  }

  load(success, beforeSend) {
    if(this.loaded) return;

    $.ajax({
      url: this.url,
      method: 'GET',
      beforeSend: () => {
        if(beforeSend) beforeSend();
        this.container.html(`
          <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-white px-6 py-5 rounded-xl shadow-xl flex items-center space-x-4 min-w-[180px]">
              <div class="animate-spin rounded-full h-7 w-7 border-2 border-blue-200 border-t-blue-600"></div>
              <span class="text-gray-800 text-sm font-medium">${this.loadingLabel}</span>
            </div>
          </div>
         `);
      },
      success: (data) =>  {
        this.loaded = true;
        this.container.html('');
        success(data, this.container);
      },
      error: (data) => {
        console.error(data.responseText);
        this.container.html(`
            <div class="text-red-500 bg-red-50 p-3 rounded-lg">
                ${this.errorLabel}
            </div>
        `);
      }
    });
  }

  unload() {
    this.loaded = false;
  }
}
