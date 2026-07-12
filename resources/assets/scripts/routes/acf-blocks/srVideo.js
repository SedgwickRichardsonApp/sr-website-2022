
export default {
  init() {
  },
  finalize() {
    const videoBlocks = $('.acf-video-block');
    if(videoBlocks.length){
      videoBlocks.each((index, video) => {
        const videoElem = $(video).find('video');
        if(videoElem.length){
          // $(video).find('video').removeAttr('muted');
        }
      });
    }
    
  },
};
