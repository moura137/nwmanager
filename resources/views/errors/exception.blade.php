@if (config('app.debug'))

    <hr/>
    <h4>Display Exceptions</h4>
    @if (isset($exception) && $exception instanceof \Exception)

        <h5>{{ get_class($exception) }}</h5>
        <dl>
            <dt>File:</dt>
            <dd>
                <pre class="prettyprint linenums">{{ $exception->getFile() }}:{{ $exception->getLine() }}</pre>
            </dd>
            <dt>Message:</dt>
            <dd>
                <pre class="prettyprint linenums">{{ $exception->getMessage() }}</pre>
            </dd>
            <dt>Stack trace:</dt>
            <dd>
                <pre class="prettyprint linenums">{{ $exception->getTraceAsString() }}</pre>
            </dd>
        </dl>

        <?php $e = $exception->getPrevious(); ?>
        @if($e)
            <h5>Previous Exceptions:</h5>
            <ul class="unstyled">
            @while($e)
                <li>
                    <h3>{{ get_class($e) }}</h3>
                    <dl>
                        <dt>File:</dt>
                        <dd>
                            <pre class="prettyprint linenums">{{ $e->getFile() }}:{{ $e->getLine() }}</pre>
                        </dd>
                        <dt>Message:</dt>
                        <dd>
                            <pre class="prettyprint linenums">{{ $e->getMessage() }}</pre>
                        </dd>
                        <dt>Stack trace:</dt>
                        <dd>
                            <pre class="prettyprint linenums">{{ $e->getTraceAsString() }}</pre>
                        </dd>
                    </dl>
                </li>
            <?php $e = $e->getPrevious(); ?>
            @endwhile
            </ul>
        @endif

    @else

        <p><strong>No Exception available</strong></p>

    @endif

@endif