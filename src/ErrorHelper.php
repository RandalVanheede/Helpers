<?php

namespace RandalVanheede\Helpers;

class ErrorHelper {

  protected string $title = 'Error page';
  protected string $header;
  protected string $content;
  protected string $footer;
  protected string $styling = 'bootstrap';
  protected array $trace = [];

  /**
   * Generates error page from stack trace.
   *
   * @param \Exception $exception
   *
   * @return static
   */
  public static function fromException(\Exception $exception): static {
    $object = new static();

    $object->trace = explode("\n", $exception->getTraceAsString());

    return $object;
  }

  /**
   * Sets the title.
   *
   * @param string $title
   *
   * @return $this
   */
  public function setTitle(string $title): static {
    $this->title = $title;
    return $this;
  }

  /**
   * Sets a flag and some boilerplate HTML to use Bootstrap as styling agent.
   *
   * @return self
   */
  public function useBootstrapStyling(): self {
    $this->styling = 'bootstrap';
    $this->header = '<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>' . $this->title .  '</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <main role="main" class="container">
      <div class="card">
        <div class="card-header">
          ' . $this->title . '
        </div>
        <div class="card-body">';
    $this->footer = '        </div>
      </div>
    </main>
  </body>
</html>';

    return $this;
  }

  /**
   * Generates the final HTML.
   *
   * @return string
   */
  public function generate(): string {
    switch ($this->styling) {
      case 'bootstrap':
        $this->generateBootstrapContent();
        break;
    }

    return $this->header . $this->content . $this->footer;
  }

  /**
   * Generates bootstrap content.
   *
   * @return void
   */
  protected function generateBootstrapContent() {
    $this->content = '<ul class="list-group">';
    foreach ($this->trace as $trace_item) {
      $this->content .= '<li class="list-group-item list-group-item-action">' . $trace_item . '></li>';
    }
    $this->content .= '</ul>';
  }

}

