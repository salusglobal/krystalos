import { KrystalosPage } from './app.po';

describe('krystalos App', () => {
  let page: KrystalosPage;

  beforeEach(() => {
    page = new KrystalosPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
